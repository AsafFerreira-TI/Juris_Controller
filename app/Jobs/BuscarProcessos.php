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
            // Aqui chama-se a lógica para salvar no Banco de Dados (updateOrCreate)
            // Ex: ProcessoService::salvar($dadosColetados);
        } else {
            // Trata erros de execução (Logar o erro para monitoramento)
            \Log::error('Erro no Bot ({$this->sistemaOrigem}): ' . $resultado->errorOutput());
        }
    }
}
