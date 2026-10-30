<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SobreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\ProcessoController;

Route::get('/processos', [ProcessoController::class, 'index'])
    ->name('processos.index');

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('processos', ProcessoController::class);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/sobre', [SobreController::class, 'index'])->name('sobre');

Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');

Route::get('/servicos', [ServicosController::class, 'index'])->name('servicos');

use App\Http\Controllers\SolucaoController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/solucoes', [SolucaoController::class, 'index'])->name('solucoes');
Route::get('/recursos', function () {
    return view('recursos');
})->name('recursos');
Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');
Route::get('/contato', function () {
    return view('contato');
})->name('contato');

use App\Http\Controllers\ConsultaController;

Route::get('/consulta', [ConsultaController::class, 'index'])->name('consulta.index');
Route::post('/consulta', [ConsultaController::class, 'buscar'])->name('consulta.buscar');

use App\Http\Controllers\AgendaController;

use App\Http\Controllers\GoogleCalendarController;

Route::middleware('auth')
    ->prefix('agenda-google')
    ->name('google-calendar.')
    ->group(function () {
        Route::get('/', [GoogleCalendarController::class, 'index'])
            ->name('index');

        Route::get('/eventos', [GoogleCalendarController::class, 'events'])
            ->name('events');
    });




/*
Copie as duas rotas abaixo para routes/web.php; não inclua este arquivo
automaticamente. Remova as rotas de teste ou proteja-as em produção.
*/
Route::get('/teste-notificacoes', function () {
    return view('notificacoes-demo');
})->name('notificacoes-demo.index');

Route::post('/teste-notificacoes', function (Request $request) {
    $tipos = ['success', 'error', 'warning', 'info'];
    $tipo = $request->input('tipo');
    if (!in_array($tipo, $tipos, true)) $tipo = 'info';

    $mensagens = [
        'success' => ['Teste concluído!', 'A notificação de sucesso está funcionando.'],
        'error' => ['Exemplo de erro', 'Esta é uma mensagem de erro demonstrativa.'],
        'warning' => ['Atenção', 'Esta é uma mensagem de aviso demonstrativa.'],
        'info' => ['Informação', 'Esta é uma mensagem informativa demonstrativa.'],
    ];

    return redirect()->route('notificacoes-demo.index')->with('toast', [
        'tipo' => $tipo,
        'titulo' => $mensagens[$tipo][0],
        'mensagem' => $mensagens[$tipo][1],
        'detalhes' => $tipo === 'success'
            ? ['O componente Blade foi renderizado.', 'O CSS foi carregado.']
            : [],
    ]);
})->name('notificacoes-demo.testar');
