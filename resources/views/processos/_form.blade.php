
@php
    $isEdit = isset($processo);
@endphp



{{-- Número Processo --}}
<div class="mb-3">

    <label class="form-label">Número Processo</label>

    <input
        type="text"
        name="num_processo"
        class="form-control"
        value="{{ old('num_processo', $processo->num_processo ?? '') }}"
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

        <option value="civel"
            {{ old('tipo_processo', $processo->tipo_processo ?? '') == 'civel' ? 'selected' : '' }}>
            Cível
        </option>

        <option value="trabalhista"
            {{ old('tipo_processo', $processo->tipo_processo ?? '') == 'trabalhista' ? 'selected' : '' }}>
            Trabalhista
        </option>

        <option value="familia"
            {{ old('tipo_processo', $processo->tipo_processo ?? '') == 'familia' ? 'selected' : '' }}>
            Família
        </option>

        <option value="execucao"
            {{ old('tipo_processo', $processo->tipo_processo ?? '') == 'execucao' ? 'selected' : '' }}>
            Execução
        </option>

        <option value="constitucional"
            {{ old('tipo_processo', $processo->tipo_processo ?? '') == 'constitucional' ? 'selected' : '' }}>
            Constitucional
        </option>

    </select>

    @error('tipo_processo')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

</div>


{{-- Descrição --}}
<div class="mb-3">

    <label class="form-label">Descrição</label>

    <input
        type="text"
        name="desc_processo"
        class="form-control"
        value="{{ old('desc_processo', $processo->desc_processo ?? '') }}"
        required
    >

    @error('desc_processo')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

</div>


{{-- Data abertura --}}
<div class="mb-3">

    <label class="form-label">Data de abertura</label>

    <input
        type="date"
        name="data_abertura_processo"
        class="form-control"
        value="{{ old('data_abertura_processo', $processo->data_abertura_processo ?? '') }}"
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
        value="{{ old('vara_processo', $processo->vara_processo ?? '') }}"
        required
    >

    @error('vara_processo')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

</div>


{{-- Status --}}
<div class="mb-3">

    <label class="form-label">Status</label>

    <select
        name="status_processo"
        class="form-control"
        required
    >

        <option value="">Selecione</option>

        <option value="andamento"
            {{ old('status_processo', $processo->status_processo ?? '') == 'andamento' ? 'selected' : '' }}>
            Em andamento
        </option>

        <option value="concluido"
            {{ old('status_processo', $processo->status_processo ?? '') == 'concluido' ? 'selected' : '' }}>
            Concluído
        </option>

        <option value="vencido"
            {{ old('status_processo', $processo->status_processo ?? '') == 'vencido' ? 'selected' : '' }}>
            Vencido
        </option>

    </select>

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
        value="{{ old('comarca', $processo->comarca ?? '') }}"
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
        value="{{ old('tribunal_processo', $processo->tribunal_processo ?? '') }}"
        required
    >

    @error('tribunal_processo')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

</div>


{{-- Cliente --}}
<div class="mb-3">

    <label class="form-label">Cliente</label>

    <input
        type="text"
        name="id_cliente"
        class="form-control"
        value="{{ old('id_cliente', $processo->id_cliente ?? '') }}"
        required
    >

    @error('id_cliente')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

</div>


{{-- Botões --}}
<div class="d-flex gap-2">

    <button type="submit" class="btn btn-primary">
        {{ $isEdit ? 'Atualizar' : 'Salvar' }}
    </button>

    <a
        href="{{ route('processos.index') }}"
        class="btn btn-secondary"
    >
        Cancelar
    </a>

</div>

<br>
