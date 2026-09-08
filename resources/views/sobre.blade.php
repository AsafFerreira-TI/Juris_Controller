@extends('layouts.app')

@section('title', 'Sobre Nós')

@section('content')

<link rel="stylesheet" href="{{ asset('css/sobre.css') }}">

<section class="sobre">

    <div class="sobre-conteudo">

        <span class="sobre-label">
            SOBRE NÓS
        </span>

        <h1>
            Tecnologia e estratégia<br>
            para escritórios que<br>
            querem <span>ir além.</span>
        </h1>

        <p>
            O Juris Control nasceu com o propósito de transformar
            a gestão jurídica por meio da tecnologia, da inovação e
            do compromisso com resultados.
        </p>

    </div>

</section>
<section class="sobre1">

    <div class="sobre1-conteudo">

    <div class="sobre1-texto">

        <span class="sobre1-label">
            NOSSA MISSÃO
        </span>

        <h1>
            Simplificar a gestão jurídica <br>
            para <span>potencializar resultados.</span>
        </h1>

        <p>
            Desenvolvemos soluções inteligentes que automatizam processos,
            organizam informações e oferecem visibilidade estratégica para
            que advogados e gestores possam focar no que realmente importa:
            pessoas e decisões que fazem a diferença.
        </p>

    </div>

    <div class="sobre1-card">

        <div class="card">
            <div class="card-body">

                <h5 class="card-title">
                <img src="{{ asset('img/seg.png') }}" alt="" srcset="">
                </h5>

                <h6 class="card-subtitle mb-2 text-muted">
                    Segurança
                </h6>

                <p class="card-text">
                    Protegemos seus dados com tecnologia de ponta e conformidade com as leis de privacidade.
                </p>

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h5 class="card-title">
                <img src="{{ asset('img/clock.png') }}" alt="" srcset="">
                </h5>

                <h6 class="card-subtitle mb-2 text-muted">
                    Eficiência
                </h6>

                <p class="card-text">
                    Automatizamos tarefas e processos para você ganhar tempo e reduzir erros operacionais.
                </p>

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h5 class="card-title">
                <img src="{{ asset('img/insight.png') }}" alt="" srcset="">
                </h5>

                <h6 class="card-subtitle mb-2 text-muted">
                    Inteligência
                </h6>

                <p class="card-text">
                    Transformamos dados em insights para decisões mais assertivas e estratégicas.
                </p>

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h5 class="card-title">
                <img src="{{ asset('img/users.png') }}" alt="" srcset="">
                </h5>

                <h6 class="card-subtitle mb-2 text-muted">
                    Parceira
                </h6>

                <p class="card-text">
                   Estamos ao seu lado em cada etapa, com suporte próximo e atendimento especializado.
                </p>

            </div>
        </div>

    </div>

</section>

<section class="time">

    <div class="time-intro">
        <span class="time-label">
            NOSSO TIME
        </span>

        <p>
           Somos especialistas em tecnologia e gestão juridica,
           apaixonados por inovação e comprometidos
           com o sucesso das nossos clientes
        </p>
    </div>
    <div class="time-card">

            <img src="{{ asset('img/time.png') }}">

    </div>

</section>

<div class="numeros-container">

    <div class="numero-item">
        <div class="numero-icone">
            <img src="{{ asset('img/users.2.png') }}" alt="Escritórios atendidos">
        </div>
        <div class="numero-texto">
            <strong>+1.500</strong>
            <span>Escritórios atendidos</span>
        </div>
    </div>

    <div class="numero-item">
        <div class="numero-icone">
            <img src="{{ asset('img/icone-processos.png') }}" alt="Processos gerenciados">
        </div>
        <div class="numero-texto">
            <strong>+2,5 milhões</strong>
            <span>Processos gerenciados</span>
        </div>
    </div>

    <div class="numero-item">
        <div class="numero-icone">
            <img src="{{ asset('img/icone-horas.png') }}" alt="Horas economizadas">
        </div>
        <div class="numero-texto">
            <strong>+200 mil</strong>
            <span>Horas economizadas</span>
        </div>
    </div>

    <div class="numero-item">
        <div class="numero-icone">
            <img src="{{ asset('img/icone-satisfacao.png') }}" alt="Satisfação dos clientes">
        </div>
        <div class="numero-texto">
            <strong>98%</strong>
            <span>Satisfação dos clientes</span>
        </div>
    </div>

</div>

@endsection
