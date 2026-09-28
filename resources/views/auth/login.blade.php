@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/form.css') }}">

<div class="container mt-4">
    <h1>Entrar</h1>

    @include('partials.alerts')


    <form action="{{ route('login') }}" method="POST" class="form-processo">
        @csrf

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


        <button class="btn btn-primary" type="submit">
            Entrar
        </button>

        <a href="{{ route('register') }}" class="btn btn-secondary">
            Criar conta
        </a>
    </form>
</div>
@endsection
