@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Bem-vindo!</h1>
    <p>Olá, {{ auth()->user()->nome_advg }}! Você está autenticado(a).</p>
</div>
@endsection
