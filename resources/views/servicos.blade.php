@extends('layouts.app')

@section('title', 'Serviços')

@section('content')

<link rel="stylesheet" href="{{ asset('css/solucoes.css') }}">

<section class="servicos-hero">
    <div class="hero-content">
        <div class="hero-text">
            <span class="lbl-orange">NOSSOS SERVIÇOS</span>
            <h1>Planos que se adaptam<br><span>ao seu escritório</span></h1>
            <p>Melhoria na eficiência do seu trabalho, redução de erros operacionais, evitando a perda de prazos importantes.</p>
        </div>
    </div>
</section>

<section class="planos-container">
    <div class="planos-header">
        <span class="lbl-orange">Planos e preços</span>
        <h2>Mais controle, mais produtividade,<br><span>mais crescimento para o seu negócio.</span></h2>
    </div>

    <div class="planos-selector">
        <button class="active">Mensal</button>
        <button>Semestral <span class="badge">-10%</span></button>
        <button>Anual <span class="badge">-20%</span></button>
    </div>

    <div class="plano-card">
        <div class="plano-card-header">
            <h3>Mensal</h3>
            <p>Ideal para profissionais que estão começando</p>
            <div class="price">R$ 59,90/mês</div>
        </div>
        <div class="plano-features">
            <div class="feature-col">
                <ul>
                    <li><span>✔</span> Gestão de Clientes</li>
                    <li><span>✔</span> Gestão de Processos</li>
                    <li><span>✔</span> Agenda Integrada</li>
                </ul>
            </div>
            <div class="feature-col">
                <ul>
                    <li><span>✔</span> Documentos</li>
                    <li><span>✔</span> Relatórios Básicos</li>
                    <li><span>✔</span> Suporte por e-mail</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="beneficios-row">
        <div class="beneficio-item">
            <div class="icon"><img src="{{ asset('img/escudo.png') }}" alt="Escudo"></div>
            <div class="text">
                <strong>Sem fidelidade</strong>
                <p>Cancele quando quiser, sem burocracia.</p>
            </div>
        </div>
        <div class="beneficio-item">
            <div class="icon"><img src="{{ asset('img/nuvem_cadeado.png') }}" alt="Nuvem"></div>
            <div class="text">
                <strong>Seus dados protegidos</strong>
                <p>Segurança avançada e backup automático.</p>
            </div>
        </div>
        <div class="beneficio-item">
            <div class="icon"><img src="{{ asset('img/headphone.png') }}" alt="Phone"></div>
            <div class="text">
                <strong>Suporte especializado</strong>
                <p>Sempre a disposição para ajudar no que precisar.</p>
            </div>
        </div>
    </div>
</section>


@endsection
