@extends('layouts.app')

@section('title', 'Processos')

@section('content')

<style>
    .processos-page {
        background: #fff;
        color: #222;
    }

    /* =========================
       HERO
    ========================= */

    .processos-hero {
        min-height: 270px;
        position: relative;
        background:
            linear-gradient(90deg, rgba(0,0,0,.90) 0%, rgba(0,0,0,.72) 42%, rgba(0,0,0,.25) 100%),
            url('/images/processos-banner.jpg') center/cover no-repeat;
        display: flex;
        align-items: center;
    }

    .processos-hero-content {
        width: 100%;
        max-width: 1200px;
        margin: auto;
        padding: 45px 30px;
    }

    .processos-hero small {
        color: #d99a00;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .processos-hero h1 {
        color: #fff;
        font-size: 36px;
        line-height: 1.15;
        font-weight: 700;
        max-width: 600px;
        margin: 10px 0;
    }

    .processos-hero h1 span {
        color: #d99a00;
    }

    .processos-hero p {
        color: #eee;
        max-width: 520px;
        line-height: 1.5;
        margin: 0;
    }

    /* =========================
       CONTAINER
    ========================= */

    .processos-container {
        max-width: 1200px;
        margin: auto;
        padding: 25px 20px 50px;
    }

    /* =========================
       CARDS
    ========================= */

    .processos-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .processo-stat {
        border: 1px solid #e3e3e3;
        border-radius: 8px;
        padding: 20px;
        background: #fff;
        min-height: 135px;
        box-shadow: 0 2px 7px rgba(0,0,0,.03);
    }

    .stat-icon {
        width: 35px;
        height: 35px;
        color: #c89000;
        font-size: 25px;
        margin-bottom: 8px;
    }

    .stat-title {
        font-size: 13px;
        color: #444;
        margin-bottom: 5px;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #171717;
    }

    .stat-change {
        font-size: 11px;
        margin-top: 5px;
    }

    .stat-up {
        color: #198754;
    }

    .stat-down {
        color: #dc3545;
    }

    /* =========================
       FILTROS
    ========================= */

    .filtros {
        background: #fafafa;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        padding: 18px;
        display: grid;
        grid-template-columns: 2.5fr 1fr 1fr 1fr auto;
        gap: 12px;
        align-items: end;
        margin-bottom: 28px;
    }

    .campo label {
        display: block;
        font-size: 11px;
        color: #555;
        margin-bottom: 5px;
    }

    .campo input,
    .campo select {
        width: 100%;
        height: 40px;
        border: 1px solid #d8d8d8;
        border-radius: 5px;
        padding: 0 12px;
        background: #fff;
        font-size: 13px;
        outline: none;
    }

    .campo input:focus,
    .campo select:focus {
        border-color: #c89000;
        box-shadow: 0 0 0 2px rgba(200,144,0,.12);
    }

    .btn-novo {
        height: 40px;
        border: 0;
        border-radius: 5px;
        padding: 0 18px;
        background: #c89000;
        color: white;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: .2s;
    }

    .btn-novo:hover {
        background: #a97800;
        color: white;
    }

    /* =========================
       TÍTULO DA LISTA
    ========================= */

    .lista-header {
        margin-bottom: 15px;
    }

    .lista-header h2 {
        font-size: 21px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .lista-header p {
        color: #777;
        font-size: 13px;
        margin: 0;
    }

    /* =========================
       TABELA
    ========================= */

    .tabela-processos {
        border: 1px solid #e5e5e5;
        border-radius: 7px;
        overflow: hidden;
        background: #fff;
    }

    .tabela-processos table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .tabela-processos thead {
        background: #f7f8f9;
    }

    .tabela-processos th {
        text-align: left;
        padding: 13px 12px;
        font-size: 11px;
        color: #444;
        font-weight: 700;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
    }

    .tabela-processos td {
        padding: 13px 12px;
        border-bottom: 1px solid #ededed;
        color: #333;
        vertical-align: middle;
    }

    .tabela-processos tr:last-child td {
        border-bottom: none;
    }

    .tabela-processos tbody tr:hover {
        background: #fffdf7;
    }

    .numero-processo {
        white-space: nowrap;
        font-size: 11px;
    }

    .processo-documento {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 27px;
        height: 27px;
        border-radius: 50%;
        background: #fff7e5;
        color: #c89000;
        margin-right: 7px;
    }

    /* =========================
       STATUS
    ========================= */

    .status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-andamento {
        background: #dff6e9;
        color: #16834a;
    }

    .status-analise {
        background: #e3efff;
        color: #2775cf;
    }

    .status-pendente {
        background: #fff0d3;
        color: #b47700;
    }

    .status-vencido {
        background: #ffe1e3;
        color: #d52c39;
    }

    /* =========================
       AÇÕES
    ========================= */

    .acoes {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .acao {
        border: none;
        background: transparent;
        cursor: pointer;
        color: #333;
        font-size: 15px;
        padding: 0;
    }

    .acao:hover {
        color: #c89000;
    }

    /* =========================
       PAGINAÇÃO
    ========================= */

    .paginacao {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        margin: 22px 0;
    }

    .pagina {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        color: #444;
        text-decoration: none;
        font-size: 12px;
        background: #fff;
    }

    .pagina:hover {
        color: #c89000;
        border-color: #c89000;
    }

    .pagina.ativa {
        background: #c89000;
        color: white;
        border-color: #c89000;
    }

    /* =========================
       CTA
    ========================= */

    .novo-processo-banner {
        background:
            linear-gradient(90deg, #0b0b0b, #151515);
        border-radius: 8px;
        padding: 20px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        margin-top: 15px;
    }

    .cta-esquerda {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .cta-icon {
        color: #d39a00;
        font-size: 36px;
    }

    .cta-text h3 {
        font-size: 18px;
        margin: 0 0 4px;
    }

    .cta-text p {
        margin: 0;
        font-size: 12px;
        color: #ccc;
    }

    /* =========================
       RESPONSIVO
    ========================= */

    @media (max-width: 1000px) {
        .processos-stats {
            grid-template-columns: repeat(3, 1fr);
        }

        .filtros {
            grid-template-columns: 1fr 1fr;
        }

        .filtros .campo:first-child {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 700px) {
        .processos-stats {
            grid-template-columns: 1fr 1fr;
        }

        .processos-hero h1 {
            font-size: 28px;
        }

        .tabela-processos {
            overflow-x: auto;
        }

        .tabela-processos table {
            min-width: 900px;
        }

        .filtros {
            grid-template-columns: 1fr;
        }

        .filtros .campo:first-child {
            grid-column: auto;
        }

        .novo-processo-banner {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
    }

    @media (max-width: 480px) {
        .processos-stats {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="processos-page">

    {{-- =========================
         BANNER
    ========================== --}}

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

                <div class="stat-icon">▤</div>

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

                <div class="stat-icon">◷</div>

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

                <div class="stat-icon">✓</div>

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

                <div class="stat-icon">△</div>

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

                <div class="stat-icon">▣</div>

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


            <button
                type="button"
                class="btn-novo"

            >
                + &nbsp; Novo processo
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

                            <td>
                                <span class="processo-documento">▤</span>
                                0009876-12.2024.8.26.0100
                            </td>

                            <td>Maria Oliveira</td>

                            <td>Revisão de Contrato</td>

                            <td>Cível</td>

                            <td>
                                <span class="status status-analise">
                                    ● Em análise
                                </span>
                            </td>

                            <td>28/06/2025</td>

                            <td>◉ &nbsp; ▣ &nbsp; ⋮</td>

                        </tr>


                        <tr>

                            <td>
                                <span class="processo-documento">▤</span>
                                0012345-67.2023.8.26.0100
                            </td>

                            <td>Empresa Alfa LTDA</td>

                            <td>Ação Trabalhista</td>

                            <td>Trabalhista</td>

                            <td>
                                <span class="status status-pendente">
                                    ● Pendente
                                </span>
                            </td>

                            <td>05/07/2025</td>

                            <td>◉ &nbsp; ▣ &nbsp; ⋮</td>

                        </tr>


                        <tr>

                            <td>
                                <span class="processo-documento">▤</span>
                                0023456-78.2024.8.26.0100
                            </td>

                            <td>Carlos Mendes</td>

                            <td>Direito do Consumidor</td>

                            <td>Cível</td>

                            <td>
                                <span class="status status-andamento">
                                    ● Em andamento
                                </span>
                            </td>

                            <td>12/07/2025</td>

                            <td>◉ &nbsp; ▣ &nbsp; ⋮</td>

                        </tr>


                        <tr>

                            <td>
                                <span class="processo-documento">▤</span>
                                0034567-89.2023.8.26.0100
                            </td>

                            <td>Ana Costa</td>

                            <td>Divórcio Litigioso</td>

                            <td>Família</td>

                            <td>
                                <span class="status status-vencido">
                                    ● Vencido
                                </span>
                            </td>

                            <td>20/05/2025</td>

                            <td>◉ &nbsp; ▣ &nbsp; ⋮</td>

                        </tr>


                        <tr>

                            <td>
                                <span class="processo-documento">▤</span>
                                0045678-90.2024.8.26.0100
                            </td>

                            <td>Tech Solutions Ltda</td>

                            <td>Direito Empresarial</td>

                            <td>Cível</td>

                            <td>
                                <span class="status status-andamento">
                                    ● Em andamento
                                </span>
                            </td>

                            <td>30/06/2025</td>

                            <td>◉ &nbsp; ▣ &nbsp; ⋮</td>

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
                ‹
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
                ›
            </a>

        </div>


        {{-- =========================
             CTA
        ========================== --}}

        <section class="novo-processo-banner">

            <div class="cta-esquerda">

                <div class="cta-icon">
                    ▣
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
