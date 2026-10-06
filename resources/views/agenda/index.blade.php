@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/calendarioaud.css') }}">

@php
    $meses = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro',
    ];

    $mesAtual = $mesAtual ?? now()->month;
    $anoAtual = $anoAtual ?? now()->year;
    $audiencias = $audiencias ?? [];
@endphp

<main
    id="calendario-audiencias"
    class="calendario-page"
    data-mes-atual="{{ $mesAtual }}"
    data-ano-atual="{{ $anoAtual }}"
    data-audiencias='@json($audiencias)'
>
    <div class="calendario-container">

        <header class="calendario-header">
            <h1 class="calendario-titulo">Calendário de audiências</h1>

            <div class="mes-selector-wrapper">
                <label for="mes-selector">Mês</label>

                <select id="mes-selector" name="mes" class="mes-selector">
                    @foreach ($meses as $numeroMes => $nomeMes)
                        <option value="{{ $numeroMes }}" @selected((int) $mesAtual === $numeroMes)>
                            {{ $nomeMes }}
                        </option>
                    @endforeach
                </select>
            </div>
        </header>

        <section class="calendario-section" aria-labelledby="calendario-mes-titulo">
            <div class="calendario-mes-header">
                <h2 id="calendario-mes-titulo"></h2>
            </div>

            <div class="dias-semana" aria-hidden="true">
                <div>Dom.</div>
                <div>Seg.</div>
                <div>Ter.</div>
                <div>Qua.</div>
                <div>Qui.</div>
                <div>Sex.</div>
                <div>Sáb.</div>
            </div>

            <div id="calendario-grid" class="calendario-grid"></div>
        </section>

        <section class="audiencias-section" aria-labelledby="audiencias-titulo">
            <div class="audiencias-header">
                <h2 id="audiencias-titulo">Audiências do dia selecionado</h2>
            </div>

            <div id="audiencias-conteudo" class="audiencias-conteudo" aria-live="polite">
                <div class="audiencias-vazio">
                    Selecione uma data com audiência para visualizar as informações.
                </div>
            </div>
        </section>

    </div>
</main>

<script src="{{ asset('js/calendarioaud.js') }}" defer></script>

@endsection
