@extends('layouts.app')

@section('title', 'Editar Processo')

@section('content')

<link rel="stylesheet" href="{{ asset('css/form.css') }}">

<div class="container mt-4">

    @include('partials.alerts')

    <form action="{{ route('processos.update', $processo->id) }}" method="POST" class="form-processo">

        <h1>Editar Processo</h1>

        @csrf
        @method('PUT')

        @include('processos._form')

    </form>

</div>

@endsection
