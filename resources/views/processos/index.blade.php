@extends('layouts.app')

@section('title', 'Processos')

@section('content')

<link rel="stylesheet" href="{{ asset('css/processos.css') }}">

<div class="processos-page">

    {{-- BANNER --}}

    <section class="processos-hero">

        <div class="processos-hero-content">

            <small>Processos</small>

            <h1>
                Acompanhe e gerencie
                seus processos de forma
                <span>simples e eficiente.</span>
            </h1>

            <p>
                Tenha acesso a todas as informações dos seus processos,
                acompanhe prazos, visualize andamentos e mantenha
                seu escritório sempre organizado.
            </p>

        </div>

    </section>


    <main class="processos-container">

        {{-- =========================
             INDICADORES
        ========================== --}}

        <section class="processos-stats">

            <div class="processo-stat">

                <div class="stat-icon">
                    <i class="fa-regular fa-envelope"></i>
                </div>

                <div class="stat-title">
                    Total de processos
                </div>

                <div class="stat-number">
                    {{ $totalProcessos ?? 00 }}
                </div>

                <div class="stat-change stat-up">
                    ↗ +12% no último mês
                </div>

            </div>


            <div class="processo-stat">

                <div class="stat-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>

                <div class="stat-title">
                    Em andamento
                </div>

                <div class="stat-number">
                    {{ $emAndamento ?? 00 }}
                </div>

                <div class="stat-change stat-up">
                    ↗ +8% no último mês
                </div>

            </div>


            <div class="processo-stat">

                <div class="stat-icon">
                    <i class="fa-solid fa-check"></i>
                </div>

                <div class="stat-title">
                    Concluídos
                </div>

                <div class="stat-number">
                    {{ $concluidos ?? 00 }}
                </div>

                <div class="stat-change stat-up">
                    ↗ +24% no último mês
                </div>

            </div>


            <div class="processo-stat">

                <div class="stat-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="stat-title">
                    Em prazo
                </div>

                <div class="stat-number">
                    {{ $emPrazo ?? 37 }}
                </div>

                <div class="stat-change stat-down">
                    ↗ -6% no último mês
                </div>

            </div>


            <div class="processo-stat">

                <div class="stat-icon">
                    <i class="fa-regular fa-calendar"></i>
                </div>

                <div class="stat-title">
                    Vencendo em breve
                </div>

                <div class="stat-number">
                    {{ $vencendo ?? 00 }}
                </div>

                <div class="stat-change stat-down">
                    ↗ +3% no último mês
                </div>

            </div>

        </section>


        {{-- =========================
             FILTROS
        ========================== --}}

        <form
            class="filtros"
            method="GET"
            action="{{ route('processos.index') }}"
        >

            <div class="campo">

                <label>Pesquisar</label>

                <input
                    type="text"
                    name="busca"
                    value="{{ request('busca') }}"
                    placeholder="Buscar por número, parte, assunto ou cliente..."
                >

            </div>


            <div class="campo">

                <label>Status</label>

                <select name="status">

                    <option value="">Todos</option>

                    <option value="andamento"
                        {{ request('status') == 'andamento' ? 'selected' : '' }}>
                        Em andamento
                    </option>

                    <option value="analise"
                        {{ request('status') == 'analise' ? 'selected' : '' }}>
                        Em análise
                    </option>

                    <option value="pendente"
                        {{ request('status') == 'pendente' ? 'selected' : '' }}>
                        Pendente
                    </option>

                    <option value="vencido"
                        {{ request('status') == 'vencido' ? 'selected' : '' }}>
                        Vencido
                    </option>

                </select>

            </div>


            <div class="campo">

                <label>Tipo de processo</label>

                <select name="tipo">

                    <option value="">Todos</option>
                    <option value="civel">Cível</option>
                    <option value="trabalhista">Trabalhista</option>
                    <option value="familia">Família</option>
                    <option value="execucao">Execução</option>
                    <option value="constitucional">Constitucional</option>

                </select>

            </div>


            <div class="campo">

                <label>Ordenar por</label>

                <select name="ordem">

                    <option value="recentes">
                        Mais recentes
                    </option>

                    <option value="antigos">
                        Mais antigos
                    </option>

                    <option value="prazo">
                        Prazo
                    </option>

                </select>

            </div>


            <button>
            <a
                        href="{{ route('processos.create') }}"
                        class="text-decoration-none"

            >
                + &nbsp; Novo processo
            </a>
            </button>

        </form>


        {{-- =========================
             TÍTULO
        ========================== --}}

        <div class="lista-header">

            <h2>
                Lista de processos
            </h2>

            <p>
                Mostrando
                {{ isset($processos) ? $processos->count() : 10 }}
                de
                {{ $totalProcessos ?? 00 }}
                processos
            </p>

        </div>


        {{-- =========================
             TABELA
        ========================== --}}

        <div class="tabela-processos">

            <table>

                <thead>

                    <tr>

                        <th>Nº do processo</th>
                        <th>Cliente</th>
                        <th>Assunto</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Prazo</th>
                        <th>Ações</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($processos ?? [] as $processo)

                        <tr>

                            <td>

                                <span class="processo-documento">
                                    ▤
                                </span>

                                <span class="numero-processo">
                                    {{ $processo->numero }}
                                </span>

                            </td>

                            <td>
                                {{ $processo->cliente }}
                            </td>

                            <td>
                                {{ $processo->assunto }}
                            </td>

                            <td>
                                {{ $processo->tipo }}
                            </td>

                            <td>

                                @php
                                    $status = strtolower($processo->status ?? '');
                                @endphp

                                @if($status == 'andamento')

                                    <span class="status status-andamento">
                                        ● Em andamento
                                    </span>

                                @elseif($status == 'analise')

                                    <span class="status status-analise">
                                        ● Em análise
                                    </span>

                                @elseif($status == 'pendente')

                                    <span class="status status-pendente">
                                        ● Pendente
                                    </span>

                                @elseif($status == 'vencido')

                                    <span class="status status-vencido">
                                        ● Vencido
                                    </span>

                                @else

                                    <span class="status status-andamento">
                                        ● {{ $processo->status }}
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $processo->prazo
                                    ? \Carbon\Carbon::parse($processo->prazo)->format('d/m/Y')
                                    : '-'
                                }}
                            </td>

                            <td>

                                <div class="acoes">

                                <!--
                                    <a
                                        href="{{ route('processos.show', $processo) }}"
                                        class="acao"
                                        title="Visualizar"
                                    >
                                        ◉
                                    </a>

                                    <a
                                        href="{{ route('processos.edit', $processo) }}"
                                        class="acao"
                                        title="Editar"
                                    >
                                        ▣
                                    </a>
-->
                                    <button
                                        type="button"
                                        class="acao"
                                        title="Mais opções"
                                    >
                                        ⋮
                                    </button>

                                </div>

                            </td>

                        </tr>
                                            @empty

                        {{-- Dados demonstrativos caso ainda não existam processos --}}

                        <tr>

                            <td>
                                <span class="processo-documento">▤</span>
                                0001234-56.2025.8.26.0100
                            </td>

                            <td>João Silva</td>

                            <td>Indenização por Danos Morais</td>

                            <td>Cível</td>

                            <td>
                                <span class="status status-andamento">
                                    ● Em andamento
                                </span>
                            </td>

                            <td>15/06/2025</td>

                            <td>◉ &nbsp; ▣ &nbsp; ⋮</td>

                        </tr>


                        <tr>

                    @endforelse
                </tbody>

            </table>

        </div>


        {{-- =========================
             PAGINAÇÃO
        ========================== --}}

        <div class="paginacao">

            <a href="#" class="pagina">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <a href="#" class="pagina ativa">
                1
            </a>

            <a href="#" class="pagina">
                2
            </a>

            <a href="#" class="pagina">
                3
            </a>

            <a href="#" class="pagina">
                4
            </a>

            <a href="#" class="pagina">
                5
            </a>

            <a href="#" class="pagina">
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>


        {{-- =========================
             CTA
        ========================== --}}

        <section class="novo-processo-banner">

            <div class="cta-esquerda">

                <div class="cta-icon">
                    <i class="fa-regular fa-calendar"></i>
                </div>

                <div class="cta-text">

                    <h3>
                        Precisa de um novo processo?
                    </h3>

                    <p>
                        Inicie um novo processo de forma rápida e segura.
                    </p>

                </div>

            </div>

<!--
            <a
                href=""
                class="btn-novo"
            >-->
                + &nbsp; Novo processo
            </a>

        </section>

    </main>

</div>

@endsection
