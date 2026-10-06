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

Route::get('/calendario-audiencias', [AgendaController::class, 'index'])
    ->name('agenda.index');
