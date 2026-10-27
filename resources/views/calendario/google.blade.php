@extends('layouts.app')

@section('content')
<div class="gcal-page"
     id="google-calendar-app"
     data-events-url="{{ route('google-calendar.events') }}"
     data-initial-year="{{ $anoInicial }}"
     data-initial-month="{{ $mesInicial }}">
    <div class="gcal-heading">
        <div>
            <h1">Calendário de audiências</h1>
            <p>Consulte os eventos do calendário integrado.</p>
        </div>
        <label class="gcal-month-picker">
            <span>Mês</span>
            <select id="gcal-month-select" aria-label="Selecionar mês"></select>
        </label>
    </div>

    <div class="gcal-layout">
        <section class="gcal-calendar-panel" aria-label="Calendário mensal">
            <div class="gcal-calendar-title">
                <button type="button" id="gcal-prev" class="gcal-nav" aria-label="Mês anterior">‹</button>
                <h2 id="gcal-month-title">Carregando calendário…</h2>
                <button type="button" id="gcal-next" class="gcal-nav" aria-label="Próximo mês">›</button>
            </div>
            <div class="gcal-weekdays" aria-hidden="true">
                <div>Dom.</div><div>Seg.</div><div>Ter.</div><div>Qua.</div>
                <div>Qui.</div><div>Sex.</div><div>Sáb.</div>
            </div>
            <div class="gcal-days" id="gcal-days" aria-live="polite"></div>
            <p class="gcal-legend"><span aria-hidden="true">●</span> Dia com audiência/evento</p>
        </section>

        <section class="gcal-details" aria-live="polite">
            <h2 id="gcal-details-title">Selecione uma data</h2>
            <div id="gcal-details-content" class="gcal-details-content">
                <p class="gcal-empty">Escolha um dia no calendário para consultar os eventos.</p>
            </div>
        </section>
    </div>
    <p class="gcal-feedback" id="gcal-feedback" role="status"></p>
</div>

<link rel="stylesheet" href="{{ asset('css/google-calendar.css') }}">
<script src="{{ asset('js/google-calendar.js') }}" defer></script>
@endsection
