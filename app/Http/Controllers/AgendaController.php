<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        $mesAtual = now()->month;
        $anoAtual = now()->year;

        /*
         * Substitua pelo Model/consulta existente no projeto quando
         * as audiências estiverem disponíveis.
         *
         * Formato aceito pela View/JS:
         * [
         *     [
         *         'data' => '2026-10-15',
         *         'horario' => '14:30',
         *         'tipo' => 'Audiência de Conciliação',
         *         'processo' => '...',
         *         'cliente' => '...',
         *         'advogado' => '...',
         *         'local' => '...',
         *         'sala' => '...',
         *         'status' => 'Agendada',
         *         'observacoes' => '...',
         *     ],
         * ]
         */
        $audiencias = [];

        return view('agenda.index', compact(
            'mesAtual',
            'anoAtual',
            'audiencias'
        ));
    }
}
