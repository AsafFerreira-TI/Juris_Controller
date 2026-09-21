@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')

<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

<div class="perfil-page">

    <!-- CABEÇALHO -->
    <div class="perfil-header">

        <div class="perfil-titulo">
            <span>PERFIL</span>

            <h1>Seus dados</h1>

            <p>
                Aqui você pode visualizar e atualizar<br>
                suas informações pessoais.
            </p>
        </div>


        <!-- CARD PRINCIPAL -->
        <div class="perfil-resumo">

            <div class="avatar">
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="perfil-identificacao">

                <h2>
                    {{ auth()->user()->nome_advg }}
                </h2>

                <p>
                    {{ auth()->user()->email_advg }}
                </p>

                <span class="tipo-conta">
                    Usuário
                </span>

            </div>

            <a href="#" class="btn-editar">
                <i class="fa-solid fa-pen"></i>
                Editar
            </a>

        </div>

    </div>


    <!-- INFORMAÇÕES -->
    <div class="informacoes-grid">

        <!-- NOME -->
        <div class="info-card">

            <div class="info-icon">
                <i class="fa-solid fa-user"></i>
            </div>

            <div>
                <span>Nome completo</span>

                <strong>
                    {{ auth()->user()->nome_advg }}
                </strong>
            </div>

        </div>


        <!-- EMAIL -->
        <div class="info-card">

            <div class="info-icon">
                <i class="fa-regular fa-envelope"></i>
            </div>

            <div>
                <span>E-mail</span>

                <strong>
                    {{ auth()->user()->email_advg }}
                </strong>
            </div>

        </div>


        <!-- TELEFONE -->
        <div class="info-card">

            <div class="info-icon">
                <i class="fa-solid fa-phone"></i>
            </div>

            <div>
                <span>Telefone</span>

                <strong>
                    {{ auth()->user()->telefone_advg ?? 'Não informado' }}
                </strong>
            </div>

        </div>


        <!-- OAB -->
        <div class="info-card">

            <div class="info-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <div>
                <span>OAB</span>

                <strong>
                    {{ auth()->user()->oab_advg ?? 'Não informado' }}
                </strong>
            </div>

        </div>

    </div>


    <!-- INFORMAÇÕES ADICIONAIS -->
    <div class="informacoes-adicionais">

        <div class="adicionais-titulo">

            <i class="fa-regular fa-file-lines"></i>

            <h2>Informações adicionais</h2>

        </div>


        <div class="linha-info">

            <span>Data de cadastro</span>

            <strong>
                {{ auth()->user()->created_at
                    ? auth()->user()->created_at->format('d/m/Y')
                    : 'Não informado'
                }}
            </strong>

        </div>


        <div class="linha-info">

            <span>Último acesso</span>

            <strong>
                {{ now()->format('d/m/Y - H:i') }}
            </strong>

        </div>


        <div class="linha-info">

            <span>Status da conta</span>

            <strong class="status-ativo">
                <i></i>
                Ativo
            </strong>

        </div>

    </div>


    <!-- BOTÃO EDITAR -->
    <a href="#" class="editar-informacoes">

        <i class="fa-solid fa-pen"></i>

        Editar informações

    </a>

</div>

@endsection
