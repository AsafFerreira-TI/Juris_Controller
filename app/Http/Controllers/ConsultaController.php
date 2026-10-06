<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('consulta');
    }

    public function buscar(Request $request)
    {
        // 1. Validação dos campos do formulário
        $request->validate([
            'numero_processo' => 'required|string',
            'tribunal' => 'required|string',
        ]);

        // 2. Limpeza do número do processo (mantém apenas os 20 dígitos numéricos do padrão CNJ)
        $numPro = $request->numero_processo;
        $numeroProcesso = preg_replace('/\D/', '', $numPro);
        $tribunal = strtolower(trim($request->tribunal));


        if (strlen($numeroProcesso) !== 20) {
            return back()->with('error', 'O número do processo deve conter exatamente 20 dígitos numéricos do padrão CNJ.');
        }

        // 3. Credenciais e Endpoint
        $apiKey = env('DATAJUD_API_KEY', 'APIKey cDZHYzlZa0JadVREZDJCendQbXY6SkJlTzNjLV9TRENyQk1RdnFKZGRQdw==');
        $endpoint = "https://api-publica.datajud.cnj.jus.br/api_publica_{$tribunal}/_search";

        // 4. Payload com Query Elasticsearch
        $payload = [
            'query' => [
                'match' => [
                    'numeroProcesso' => $numeroProcesso
                ]
            ]
        ];

        try {
            // 5. Requisição POST com cabeçalho de autorização
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(20)->post($endpoint, $payload);

            if ($response->successful()) {
                $dados = $response->json();
                $hits = $dados['hits']['hits'] ?? [];

                if (empty($hits)) {
                    return view('consulta', [
                        'processo' => null,
                        'mensagem' => 'Nenhum registro encontrado para este processo no tribunal selecionado.'
                    ]);
                }

                $processo = $hits[0]['_source'] ?? null;

                return view('consulta', compact('processo'));
            }

            return back()->with('error', 'Erro retornado pela API do DataJud: ' . ($response->json('message') ?? $response->status()));

        } catch (\Exception $e) {
            return back()->with('error', 'Não foi possível conectar à API do DataJud: ' . $e->getMessage());
        }
    }
}
