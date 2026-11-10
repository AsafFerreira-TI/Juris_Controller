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
                    <option value="auto" {{ old('tribunal') === 'auto' ? 'selected' : '' }}>
                        Não sei / Detectar automaticamente
                    </option>
                    <option value="tjsp" {{ old('tribunal') === 'tjsp' ? 'selected' : '' }}>TJSP (São Paulo)</option>
                    <option value="tjmg" {{ old('tribunal') === 'tjmg' ? 'selected' : '' }}>TJMG (Minas Gerais)</option>
                    <option value="tjrj" {{ old('tribunal') === 'tjrj' ? 'selected' : '' }}>TJRJ (Rio de Janeiro)</option>
                    <option value="trf1" {{ old('tribunal') === 'trf1' ? 'selected' : '' }}>TRF1 (Federal Região 1)</option>
                    <option value="trt2" {{ old('tribunal') === 'trt2' ? 'selected' : '' }}>TRT2 (Trabalhista SP)</option>
                    <option value="trt15" {{ old('tribunal') === 'trt15' ? 'selected' : '' }}>TRT15 (Trabalhista Campinas)</option>
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
    @php
        // ===== Extração de tipo_processo a partir da Classe Judicial =====
        $classeNome = mb_strtolower($processo['classe']['nome'] ?? '', 'UTF-8');
        $tipoProcesso = '';
        if (str_contains($classeNome, 'cível') || str_contains($classeNome, 'civel')) {
            $tipoProcesso = 'civel';
        } elseif (str_contains($classeNome, 'trabalhista')) {
            $tipoProcesso = 'trabalhista';
        } elseif (str_contains($classeNome, 'família') || str_contains($classeNome, 'familia')) {
            $tipoProcesso = 'familia';
        } elseif (str_contains($classeNome, 'execução') || str_contains($classeNome, 'execucao')) {
            $tipoProcesso = 'execucao';
        } elseif (str_contains($classeNome, 'constitucional')) {
            $tipoProcesso = 'constitucional';
        }

        // ===== Extração de comarca a partir do Órgão Julgador =====
        $orgaoNome = $processo['orgaoJulgador']['nome'] ?? '';
        $comarca = '';
        if (preg_match('/Comarca\s+de\s+([^\/\-,]+)/i', $orgaoNome, $m)) {
            $comarca = trim($m[1]);
        } elseif (preg_match('/-\s*(.+)$/u', $orgaoNome, $m)) {
            $comarca = trim($m[1]);
        }

        // ===== Extração de status_processo a partir dos movimentos =====
        $statusProcesso = 'andamento';
        $movimentos = $processo['movimentos'] ?? [];
        $codigosEncerramento = [22, 246]; // Baixa Definitiva, Arquivamento

        foreach ($movimentos as $mov) {
            $codigo = $mov['codigo'] ?? null;
            if (in_array($codigo, $codigosEncerramento, true)) {
                $statusProcesso = 'concluido';
                break;
            }
        }

    @endphp

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
                <p class="resultado-label">Comarca (detectada):</p>
                <p class="resultado-value">{{ $comarca ?: 'Não identificada' }}</p>
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

        <div class="consulta-acoes" style="margin-top: 20px; text-align: right;">
            <form action="{{ route('processos.createFromConsulta') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="num_processo" value="{{ $processo['numeroProcesso'] ?? '' }}">
                    <input type="hidden" name="tribunal_processo" value="{{ $tribunalUsado ?? '' }}">
                <input type="hidden" name="vara_processo" value="{{ $processo['orgaoJulgador']['nome'] ?? '' }}">
                <input type="hidden" name="data_abertura_processo" value="{{ isset($processo['dataAjuizamento']) ? \Carbon\Carbon::parse($processo['dataAjuizamento'])->format('Y-m-d') : '' }}">
                <input type="hidden" name="desc_processo" value="{{ $processo['classe']['nome'] ?? '' }}">
                <input type="hidden" name="tipo_processo" value="{{ $tipoProcesso }}">
                <input type="hidden" name="comarca" value="{{ $comarca }}">
                <input type="hidden" name="status_processo" value="{{ $statusProcesso }}">

                <button type="submit" class="btn-consulta">+ Adicionar processo</button>
            </form>
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
