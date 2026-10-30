@extends('layouts.app')

@section('title', 'Início')

@section('content')

<link rel="stylesheet" href="{{ asset('css/consulta.css') }}">

<section class="consulta-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><span class="lbl-orange">Consulta Processual</span></h1>
        </div>
    </div>
</section>

@if(session('error'))
    <div class="consulta-alert consulta-alert-error">
        {{ session('error') }}
    </div>
@endif

@if(isset($mensagem))
    <div class="consulta-alert consulta-alert-warning">
        {{ $mensagem }}
    </div>
@endif

<section class="consulta-container">
    <div class="consulta-section-header">
        <h2>Consultar Processo Judicial</h2>
        <p>Informe o número do processo e o tribunal correspondente.</p>
    </div>

    <form action="{{ route('consulta.buscar') }}" method="POST" class="consulta-form" id="formConsulta">
        @csrf

        <div class="form-processo">
            <div class="form-group">
                <label for="numero_processo">Número do Processo (CNJ)</label>
                <input type="text"
                       name="numero_processo"
                       id="numero_processo"
                       value="{{ old('numero_processo') }}"
                       placeholder="0000000-00.0000.0.00.0000"
                       required>
            </div>

            <div class="form-group">
                <label for="tribunal">Tribunal</label>
                <select name="tribunal" id="tribunal" required>
                    <option value="">Selecione...</option>
                    <option value="nao">Não lembro</option>
                    <option value="tjsp">TJSP (São Paulo)</option>
                    <option value="tjmg">TJMG (Minas Gerais)</option>
                    <option value="tjrj">TJRJ (Rio de Janeiro)</option>
                    <option value="trf1">TRF1 (Federal Região 1)</option>
                    <option value="trt2">TRT2 (Trabalhista SP)</option>
                    <option value="trt15">TRT15 (Trabalhista Campinas)</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-consulta" id="btnConsultar">
                Consultar Processo
            </button>
        </div>
    </form>
</section>

@if(isset($processo) && !empty($processo))
    <section class="consulta-resultados">
        <h3>Detalhes do Processo</h3>

        <div class="resultado-grid">
            <div class="resultado-item">
                <p class="resultado-label">Número Único CNJ:</p>
                <p class="resultado-value">{{ $processo['numeroProcesso'] }}</p>
            </div>

            <div class="resultado-item">
                <p class="resultado-label">Tribunal de Origem:</p>
                <p class="resultado-value uppercase">{{ $processo['siglaTribunal'] ?? 'Não informado' }}</p>
            </div>

            <div class="resultado-item">
                <p class="resultado-label">Classe Judicial:</p>
                <p class="resultado-value">{{ $processo['classe']['nome'] ?? 'Não informada' }}</p>
            </div>

            <div class="resultado-item">
                <p class="resultado-label">Órgão Julgador:</p>
                <p class="resultado-value">{{ $processo['orgaoJulgador']['nome'] ?? 'Não informado' }}</p>
            </div>

            <div class="resultado-item">
                <p class="resultado-label">Data de Distribuição / Ajuizamento:</p>
                <p class="resultado-value">
                    {{ isset($processo['dataAjuizamento']) ? \Carbon\Carbon::parse($processo['dataAjuizamento'])->format('d/m/Y H:i') : 'Não informada' }}
                </p>
            </div>
        </div>

        <div class="assuntos-box">
            <h4>Assuntos</h4>

            @if(!empty($processo['assuntos']))
                <ul class="assuntos-lista">
                    @foreach($processo['assuntos'] as $codigo)
                        <li class="assunto-item">
                            <span class="assunto-nome">{{ $codigo['nome'] ?? 'Assunto sem nome registrado' }}</span>
                            @if(isset($codigo['codigo']))
                                <span class="assunto-codigo">Código: {{ $codigo['codigo'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="sem-assuntos">Sem assuntos cadastrados na API Pública para este processo.</p>
            @endif
        </div>
    </section>

@endif

<script>
    document.getElementById('formConsulta').addEventListener('submit', function () {
        const btn = document.getElementById('btnConsultar');
        btn.disabled = true;
        btn.innerText = 'Consultando...';
    });
</script>

@endsection
