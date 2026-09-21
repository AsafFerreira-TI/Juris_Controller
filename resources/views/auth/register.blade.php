@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Criar conta</h1>

    <form action="{{ route('register') }}" method="POST" class="mt-3">
        @csrf

        {{-- Nome --}}
        <div class="mb-3">
            <label class="form-label">Nome Completo</label>
            <input
                type="text"
                name="nome_advg"
                class="form-control"
                value="{{ old('nome_advg') }}"
                required
            >
            @error('nome_advg')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- E-mail --}}
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input
                type="email"
                name="email_advg"
                class="form-control"
                value="{{ old('email_advg') }}"
                required
            >
            @error('email_advg')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- OAB --}}
        <div class="mb-3">
            <label class="form-label">OAB</label>
            <input
                type="text"
                name="oab_advg"
                class="form-control"
                value="{{ old('oab_advg') }}"
                required
            >
            @error('oab_advg')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- CPF --}}
        <div class="mb-3">
            <label class="form-label">CPF</label>
            <input
                type="text"
                name="cpf_advg"
                class="form-control"
                value="{{ old('cpf_advg') }}"
                required
            >
            @error('cpf_advg')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Telefone --}}
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input
                type="text"
                name="telefone_advg"
                class="form-control"
                value="{{ old('telefone_advg') }}"
                required
            >
            @error('telefone_advg')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Senha --}}
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input
                type="password"
                name="password"
                class="form-control"
                required
            >
            @error('password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirmar senha --}}
        <div class="mb-3">
            <label class="form-label">Confirmar senha</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button class="btn btn-primary" type="submit">
            Cadastrar
        </button>
    </form>
</div>
@endsection
