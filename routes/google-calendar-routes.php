<?php

use App\Http\Controllers\GoogleCalendarController;
use Illuminate\Support\Facades\Route;

// Copie estas rotas para routes/web.php.
// Se o projeto usa outro middleware de autenticação, adapte ao padrão existente.
Route::middleware('auth')->prefix('agenda-google')->name('google-calendar.')->group(function () {
    Route::get('/', [GoogleCalendarController::class, 'index'])->name('index');
    Route::get('/eventos', [GoogleCalendarController::class, 'events'])->name('events');
});
