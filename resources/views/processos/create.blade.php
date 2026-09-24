@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Crsdastrar Processo</h1>

    <form action="{{ route('processos.store') }}" method="POST" class="mt-3">
        @csrf

        {{-- Número Processo --}}
        <div class="mb-3">
            <label class="form-label">Número Processo</label>
            <input
                type="text"
                name="num_processo"
                class="form-control"
                value="{{ old('num_processo') }}"
                required
            >
            @error('num_processo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tipo Processo --}}
        <div class="campo">

                <label>Tipo de processo</label>

                <select name="tipo_processo" class="form-control" required>
                    <option value="">Selecione</option>

                    <option value="civel" {{ old('tipo_processo') == 'civel' ? 'selected' : '' }}>
                        Cível
                    </option>

                    <option value="trabalhista" {{ old('tipo_processo') == 'trabalhista' ? 'selected' : '' }}>
                        Trabalhista
                    </option>

                    <option value="familia" {{ old('tipo_processo') == 'familia' ? 'selected' : '' }}>
                        Família
                    </option>

                    <option value="execucao" {{ old('tipo_processo') == 'execucao' ? 'selected' : '' }}>
                        Execução
                    </option>

                    <option value="constitucional" {{ old('tipo_processo') == 'constitucional' ? 'selected' : '' }}>
                        Constitucional
                    </option>
                </select>
            @error('tipo_processo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- desc_processo --}}
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input
                type="text"
                name="desc_processo"
                class="form-control"
                value="{{ old('desc_processo') }}"
                required
            >
            @error('desc_processo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Data abertura --}}
        <div class="mb-3">
            <label class="form-label">Data</label>
            <input
                type="date"
                name="data_abertura_processo"
                class="form-control"
                value="{{ old('data_abertura_processo') }}"
                required
            >
            @error('data_abertura_processo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Vara --}}
        <div class="mb-3">
            <label class="form-label">Vara</label>
            <input
                type="text"
                name="vara_processo"
                class="form-control"
                value="{{ old('vara_processo') }}"
                required
            >
            @error('vara_processo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">status</label>
            <input
                type="text"
                name="status_processo"
                class="form-control"
                value="{{ old('status_processo') }}"
                required
            >
            @error('status_processo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Comarca --}}
        <div class="mb-3">
            <label class="form-label">Comarca</label>
            <input
                type="text"
                name="comarca"
                class="form-control"
                value="{{ old('comarca') }}"
                required
            >
            @error('comarca')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tribunal --}}
        <div class="mb-3">
            <label class="form-label">Tribunal</label>
            <input
                type="text"
                name="tribunal_processo"
                class="form-control"
                value="{{ old('tribunal_processo') }}"
                required
            >
            @error('tribunal_processo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- liente --}}
        <div class="mb-3">
            <label class="form-label">Tribunal</label>
            <input
                type="text"
                name="id_cliente"
                class="form-control"
                value="{{ old('id_cliente') }}"
                required
            >
            @error('id_cliente')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>


        <button class="btn btn-primary" type="submit">
            Cadastrar
        </button>
    </form>
</div>
@endsection
