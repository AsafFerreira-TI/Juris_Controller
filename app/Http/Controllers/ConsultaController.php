<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('consulta');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'numero_processo' => 'required|string',
            'tribunal' => 'required|string',
        ]);

        $numPro = $request->numero_processo;
        $numeroProcesso = preg_replace('/\D/', '', $numPro);
        $tribunal = strtolower(trim($request->tribunal));

        if ($tribunal === 'nao') {
            return back()->with('error', 'Selecione um tribunal válido para realizar a consulta.');
        }

        if (strlen($numeroProcesso) !== 20) {
            return back()->with('error', 'O número do processo deve conter exatamente 20 dígitos numéricos.');
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

        // Configuração de resiliência
        $maxAttempts = 3;
        $currentAttempt = 0;

        while ($currentAttempt < $maxAttempts) {
            $currentAttempt++;

            try {
                $response = Http::withHeaders([
                    'Authorization' => $apiKey,
                    'Content-Type'  => 'application/json',
                ])
                ->connectTimeout(10)
                ->timeout(30)
                ->post($endpoint, $payload);


                // Sucesso
                if ($response->successful()) {
                    $dados = $response->json();
                    $hits = $dados['hits']['hits'] ?? [];

                    if (empty($hits)) {
                        return view('consulta', [
                            'processo' => null,
                            'mensagem' => 'Nenhum registro encontrado.'
                        ]);
                    }

                    $processo = $hits[0]['_source'] ?? null;
                    return view('consulta', compact('processo'));
                }

                // Tratamento de Erros (429 ou 5xx)
                $status = $response->status();
                if ($status === 429 || $status >= 500) {
                    // Se ainda houver tentativas, espera um pouco e continua
                    if ($currentAttempt < $maxAttempts) {
                        $wait = ($status === 429) ? 2 : 1; // 429 espera mais
                        sleep($wait * $currentAttempt);
                        continue;
                    }
                }

                return back()->with('error', "Erro na API (Status $status). Tente novamente mais tarde.");

            } catch (ConnectionException $e) {
                \Log::error('Erro de conexão com DataJud', [
                    'message' => $e->getMessage(),
                    'numero_processo' => $numeroProcesso,
                    'tribunal' => $tribunal,
                ]);

                if ($currentAttempt < $maxAttempts) {
                    sleep($currentAttempt);
                    continue;
                }

                return back()->with('error', 'Falha na conexão com o servidor. Tente novamente em alguns instantes.');
            } catch (\Exception $e) {
                return back()->with('error', 'Erro inesperado: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'A API do DataJud está instável no momento. Tente novamente em alguns instantes.');
    }
}
