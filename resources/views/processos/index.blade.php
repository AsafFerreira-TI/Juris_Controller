@extends('layouts.app')

@section('title', 'Processos')

@section('content')

<link rel="stylesheet" href="{{ asset('css/processos.css') }}">

@include('partials.alerts')

<div class="processos-page">

    {{-- BANNER --}}
<!--
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
-->


    <main class="processos-container">

        {{-- INDICADORES --}}

        <section class="processos-stats">

            <div class="processo-stat">

                <div class="stat-icon">
                    <i class="fa-regular fa-envelope"></i>
                </div>

                <div class="stat-title">
                    Total de processos
                </div>

                <div class="stat-number">
                    {{ $totalProcessos ?? '' }}
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
                    {{ $emAndamento ?? '' }}
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
                    {{ $concluidos ?? '' }}
                </div>

            </div>


            <div class="processo-stat">

                <div class="stat-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="stat-title">
                    Vencidos
                </div>

                <div class="stat-number">
                    {{ $vencidos ?? 0 }}
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

            {{-- Pesquisa --}}
            <div class="campo">
                <label>Pesquisar</label>

                <input
                    type="text"
                    name="busca"
                    value="{{ request('busca') }}"
                    placeholder="Buscar por número, descrição ou cliente..."
                >
            </div>

            {{-- Status --}}
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

            {{-- Tipo --}}
            <div class="campo">
                <label>Tipo de processo</label>

                <select name="tipo">

                    <option value="">Todos</option>

                    <option value="civel"
                        {{ request('tipo') == 'civel' ? 'selected' : '' }}>
                        Cível
                    </option>

                    <option value="trabalhista"
                        {{ request('tipo') == 'trabalhista' ? 'selected' : '' }}>
                        Trabalhista
                    </option>

                    <option value="familia"
                        {{ request('tipo') == 'familia' ? 'selected' : '' }}>
                        Família
                    </option>

                    <option value="execucao"
                        {{ request('tipo') == 'execucao' ? 'selected' : '' }}>
                        Execução
                    </option>

                    <option value="constitucional"
                        {{ request('tipo') == 'constitucional' ? 'selected' : '' }}>
                        Constitucional
                    </option>

                </select>
            </div>

            {{-- Ordenação --}}
            <div class="campo">
                <label>Ordenar por</label>

                <select name="ordem">

                    <option value="recentes"
                        {{ request('ordem', 'recentes') == 'recentes' ? 'selected' : '' }}>
                        Mais recentes
                    </option>

                    <option value="antigos"
                        {{ request('ordem') == 'antigos' ? 'selected' : '' }}>
                        Mais antigos
                    </option>

                    <option value="prazo"
                        {{ request('ordem') == 'prazo' ? 'selected' : '' }}>
                        Prazo
                    </option>

                </select>
            </div>

            {{-- Botão filtrar --}}
            <button type="submit" class="btn btn-primary">
                Filtrar
            </button>

        </form>

{{-- =========================
TABELA DE PROCESSOS
========================== --}}

<div class="lista-header">

<h2>Processos cadastrados</h2>

<p>
    Visualize e gerencie os processos cadastrados no sistema.
</p>

</div>

<div class="tabela-processos">

<table>

    <thead>

        <tr>

            <th>Nº do processo</th>

            <th>Comarca</th>

            <th>Tribunal</th>

            <th>Tipo</th>

            <th>Status</th>

            <th>Data de abertura</th>

            <th>Ações</th>

        </tr>

    </thead>


    <tbody>

        @forelse ($processos as $processo)

            <tr>

                {{-- Número do processo --}}
                <td>

                    <span class="processo-documento">
                        <i class="fa-regular fa-file-lines"></i>
                    </span>

                    <strong class="numero-processo">
                        {{ $processo->num_processo }}
                    </strong>

                </td>


                {{-- Comarca --}}
                <td>

                    {{ $processo->comarca ?? 'Não informado' }}

                </td>


                {{-- Tribunal --}}
                <td>

                    {{ $processo->tribunal_processo ?? 'Não informado' }}

                </td>


                {{-- Tipo --}}
                <td>

                    {{ $processo->tipo_processo ?? 'Não informado' }}

                </td>


                {{-- Status --}}
                <td>

                    @php

                        $status = strtolower(
                            trim($processo->status_processo ?? '')
                        );

                    @endphp


                    @if ($status === 'andamento' || $status === 'em andamento')

                        <span class="status status-andamento">
                            Em andamento
                        </span>

                    @elseif ($status === 'vencido')

                        <span class="status status-vencido">
                            Vencido
                        </span>

                    @elseif ($status === 'concluido')

                    <span class="status status-concluido">
                        Concluído
                    </span>

                    @else

                        <span class="status">
                            {{ $processo->status_processo ?? 'Não informado' }}
                        </span>

                    @endif

                </td>


                {{-- Data de abertura --}}
                <td>

                    @if (!empty($processo->data_abertura_processo))

                        {{ \Carbon\Carbon::parse(
                            $processo->data_abertura_processo
                        )->format('d/m/Y') }}

                    @else

                        <span style="color: #999;">
                            Não informado
                        </span>

                    @endif

                </td>


                {{-- Ações --}}
                <td>

                    <div class="acoes">

                        {{-- Visualizar --}}
                        <a
                            href="{{ route('processos.show', ['processo' => $processo->id]) }}"
                            class="acao"
                            title="Visualizar"
                        >
                            <i class="fa-regular fa-eye"></i>
                        </a>

                        {{-- Editar --}}
                        <a
                            href="{{ route('processos.edit', ['processo' => $processo->id]) }}"
                            class="acao"
                            title="Editar"
                        >
                            <i class="fa-solid fa-pen"></i>
                        </a>


                        {{-- Excluir --}}
                        <form
                            action="{{ route('processos.destroy', $processo->id) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Tem certeza que deseja excluir este processo?')"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="acao"
                                title="Excluir"
                            >
                                <i class="fa-regular fa-trash-can"></i>
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="8"
                    style="
                        text-align: center;
                        padding: 45px 20px;
                        color: #777;
                    "
                >

                    <i
                        class="fa-regular fa-folder-open"
                        style="
                            font-size: 30px;
                            color: #c89000;
                            margin-bottom: 10px;
                        "
                    ></i>

                    <br>

                    Nenhum processo encontrado.

                </td>

            </tr>

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
            <a
            href="{{ route('processos.create') }}"
            class="btn btn-success mt-2"

            >

            + Novo processo

            </a>

        </section>

    </main>

</div>

@endsection
