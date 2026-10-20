<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\User;
use App\Models\Processo;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Crypt;

class BuscarProcessos implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $userId;
    protected $numeroProcesso;
    protected $sistemaOrigem;

    public function __construct($userId, $numeroProcesso, $sistemaOrigem)
    {
        $this->userId = $userId;
        $this->numeroProcesso = $numeroProcesso;
        $this->sistemaOrigem = $sistemaOrigem;
    }

    // Execute the job.
    public function handle(): void
    {
        // 1. Busca o advogado no banco de dados
        $advogado = User::findOrFail($this->userId);

        // 2. Descriptografa a senha na memória
        $senhaDescrip = Crypt::decryptString($advogado->password);

         // 3. Monta o payload JSON com as credenciais
        $credenciais = json_encode([
            'usuario' => $advogado->cpf_advg,
            'senha'   => $senhaDescrip
        ]);

        // 4. Executa o script Python passando as credenciais via argumento
        $resultado = Process::run([
            'python3',
            base_path('python/factory_bot.py'),
            $credenciais,
            $this->sistemaOrigem,
            $this->numeroProcesso
        ]);

        // 5. Trata o retorno do Python
        if ($resultado->successful()) {
            $dadosColetados = json_decode($resultado->output(), true);

            if (isset($dados['sucesso']) && $dados['sucesso']) {

                // 1. Atualiza ou Cria o processo usando o 'num_processo' como identificador exclusivo
                $processo = \App\Models\Processo::updateOrCreate(
                    ['num_processo' => $dados['processo']['num_processo']],
                    [
                        'id_advg'                => $this->userId, // Vincula ao advogado que disparou o bot
                        'id_cliente'             => $this->idCliente ?? null, // Caso vinculem a um cliente na tela
                        'tipo_processo'          => $dados['processo']['tipo_processo'],
                        'vara_processo'          => $dados['processo']['vara_processo'],
                        'comarca'                => $dados['processo']['comarca'],
                        'tribunal_processo'      => $dados['processo']['tribunal_processo'],
                        'status_processo'        => $dados['processo']['status_processo'],
                        'data_abertura_processo' => $dados['processo']['data_abertura_processo'],
                    ]
                );

                // 2. Passa um loop nas audiências retornadas e vincula ao ID do processo gerado acima
                if (!empty($dados['audiencias'])) {
                    foreach ($dados['audiencias'] as $aud) {
                        $processo->audiencias()->updateOrCreate(
                            ['data_audiencia' => $aud['data_audiencia']], // Evita duplicar audiência no mesmo horário
                            [
                                'tipo_audiencia'   => $aud['tipo_audiencia'],
                                'local_audiencia'  => $aud['local_audiencia'],
                                'status_audiencia' => $aud['status_audiencia'],
                                'link_audiencia'   => $aud['link_audiencia'],
                            ]
                        );
                    }
                }
            }
        }
        else {
            // Trata erros de execução (Logar o erro para monitoramento)
            \Log::error('Erro no Bot ({$this->sistemaOrigem}): ' . $resultado->errorOutput());
        }
    }
}
