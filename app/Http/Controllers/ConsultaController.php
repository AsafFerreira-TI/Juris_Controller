<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;

class ConsultaController extends Controller
{
    private array $mapaTribunais = [
        // Justiça Estadual
        '8.01' => 'tjac',
        '8.02' => 'tjal',
        '8.03' => 'tjap',
        '8.04' => 'tjam',
        '8.05' => 'tjba',
        '8.06' => 'tjce',
        '8.07' => 'tjdft',
        '8.08' => 'tjes',
        '8.09' => 'tjgo',
        '8.10' => 'tjma',
        '8.11' => 'tjmt',
        '8.12' => 'tjms',
        '8.13' => 'tjmg',
        '8.14' => 'tjpa',
        '8.15' => 'tjpb',
        '8.16' => 'tjpr',
        '8.17' => 'tjpe',
        '8.18' => 'tjpi',
        '8.19' => 'tjrj',
        '8.20' => 'tjrn',
        '8.21' => 'tjrs',
        '8.22' => 'tjro',
        '8.23' => 'tjrr',
        '8.24' => 'tjsc',
        '8.25' => 'tjse',
        '8.26' => 'tjsp',
        '8.27' => 'tjto',

        // Justiça Federal
        '4.01' => 'trf1',
        '4.02' => 'trf2',
        '4.03' => 'trf3',
        '4.04' => 'trf4',
        '4.05' => 'trf5',
        '4.06' => 'trf6',

        // Justiça do Trabalho
        '5.01' => 'trt1',
        '5.02' => 'trt2',
        '5.03' => 'trt3',
        '5.04' => 'trt4',
        '5.05' => 'trt5',
        '5.06' => 'trt6',
        '5.07' => 'trt7',
        '5.08' => 'trt8',
        '5.09' => 'trt9',
        '5.10' => 'trt10',
        '5.11' => 'trt11',
        '5.12' => 'trt12',
        '5.13' => 'trt13',
        '5.14' => 'trt14',
        '5.15' => 'trt15',
        '5.16' => 'trt16',
        '5.17' => 'trt17',
        '5.18' => 'trt18',
        '5.19' => 'trt19',
        '5.20' => 'trt20',
        '5.21' => 'trt21',
        '5.22' => 'trt22',
        '5.23' => 'trt23',
        '5.24' => 'trt24',

        // Tribunais Superiores
        '3.00' => 'stj',
        '5.00' => 'tst',
        '6.00' => 'tse',
        '7.00' => 'stm',
    ];

    public function index()
    {
        return view('consulta');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'numero_processo' => 'required|string',
            'tribunal'        => 'required|string',
        ]);

        $numPro = $request->numero_processo;
        $numeroProcesso = preg_replace('/\D/', '', $numPro);
        $tribunal = strtolower(trim($request->tribunal));

        if (strlen($numeroProcesso) !== 20) {
            return back()->with('error', 'O número do processo deve conter exatamente 20 dígitos numéricos.');
        }

        // Se o usuário não souber o tribunal, deriva do próprio número CNJ
        if ($tribunal === 'auto' || $tribunal === 'nao' || $tribunal === '') {
            $j  = $numeroProcesso[13];
            $tr = substr($numeroProcesso, 14, 2);
            $codigoCnj = "{$j}.{$tr}";

            if (!isset($this->mapaTribunais[$codigoCnj])) {
                return back()->with('error', 'Não foi possível identificar automaticamente o tribunal para este número. Selecione o tribunal manualmente.');
            }

            $tribunal = $this->mapaTribunais[$codigoCnj];
        }

        $apiKey = env('DATAJUD_API_KEY', 'APIKey cDZHYzlZa0JadVREZDJCendQbXY6SkJlTzNjLV9TRENyQk1RdnFKZGRQdw==');
        $endpoint = "https://api-publica.datajud.cnj.jus.br/api_publica_{$tribunal}/_search";

        $payload = [
            'query' => [
                'match' => [
                    'numeroProcesso' => $numeroProcesso
                ]
            ]
        ];

        $cacheKey = "datajud:{$tribunal}:{$numeroProcesso}";

        $resultado = Cache::remember($cacheKey, 3600, function () use ($apiKey, $endpoint, $payload, $numeroProcesso, $tribunal) {

            $maxAttempts = 4;
            $currentAttempt = 0;

            while ($currentAttempt < $maxAttempts) {
                $currentAttempt++;

                try {
                    $response = Http::withHeaders([
                        'Authorization' => $apiKey,
                        'Content-Type'  => 'application/json',
                    ])
                    ->connectTimeout(15)
                    ->timeout(45)
                    ->post($endpoint, $payload);

                    if ($response->failed()) {
                        $status = $response->status();

                        if ($status === 429 || ($status >= 500 && $status !== 504)) {
                            if ($currentAttempt < $maxAttempts) {
                                $wait = ($status === 429) ? 2 : 1;
                                sleep($wait * $currentAttempt);
                                continue;
                            }
                        }

                        return [
                            'erro'     => true,
                            'mensagem' => "Erro na API (Status $status). Tente novamente mais tarde.",
                        ];
                    }

                    $dados = $response->json();
                    $hits = $dados['hits']['hits'] ?? [];
                    $shardsFailed = $dados['_shards']['failed'] ?? 0;
                    $timedOut = $dados['timed_out'] ?? false;

                    if (!empty($hits)) {
                        return [
                            'erro'     => false,
                            'processo' => $hits[0]['_source'] ?? null,
                            'mensagem' => null,
                        ];
                    }

                    if (empty($hits) && ($shardsFailed > 0 || $timedOut)) {
                        \Log::warning('DataJud: busca vazia, mas resposta inconsistente. Retentando.', [
                            'numero_processo' => $numeroProcesso,
                            'shards_failed'  => $shardsFailed,
                            'timed_out'      => $timedOut,
                            'attempt'        => $currentAttempt,
                        ]);

                        if ($currentAttempt < $maxAttempts) {
                            sleep(3 * $currentAttempt);
                            continue;
                        }

                        return [
                            'erro'     => true,
                            'mensagem' => 'A API do DataJud está instável. A consulta retornou dados parciais. Tente novamente em alguns instantes.',
                        ];
                    }

                    if (empty($hits) && $shardsFailed === 0 && !$timedOut) {
                        return [
                            'erro'     => false,
                            'processo' => null,
                            'mensagem' => 'Nenhum registro encontrado. (A base pública pode ter atraso na indexação de processos recentes.)',
                        ];
                    }

                } catch (ConnectionException $e) {
                    \Log::error('Erro de conexão com DataJud', [
                        'message'         => $e->getMessage(),
                        'numero_processo' => $numeroProcesso,
                        'tribunal'        => $tribunal,
                        'attempt'         => $currentAttempt,
                    ]);

                    if ($currentAttempt < $maxAttempts) {
                        sleep($currentAttempt * 3);
                        continue;
                    }

                    return [
                        'erro'     => true,
                        'mensagem' => 'Falha na conexão com o servidor. A API pode estar sobrecarregada. Tente novamente em alguns instantes.',
                    ];
                } catch (\Exception $e) {
                    return [
                        'erro'     => true,
                        'mensagem' => 'Erro inesperado: ' . $e->getMessage(),
                    ];
                }
            }

            return [
                'erro'     => true,
                'mensagem' => 'A API do DataJud está instável no momento. Tente novamente em alguns instantes.',
            ];
        });

        if (!empty($resultado['erro'])) {
            Cache::put($cacheKey, $resultado, 60);
            return back()->with('error', $resultado['mensagem']);
        }

        return view('consulta', [
            'processo' => $resultado['processo'] ?? null,
            'mensagem' => $resultado['mensagem'] ?? null,
            'tribunalUsado' => $tribunal,
        ]);
    }
}
