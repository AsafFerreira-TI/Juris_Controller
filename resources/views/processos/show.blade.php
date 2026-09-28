@extends('layouts.app')
@section('title', 'Processo')
@section('content')

<link rel="stylesheet" href="{{ asset('css/form.css') }}">

    <div class="container mt-4">

    @include('partials.alerts')

     <form action="{{ route('processos.show', $processo) }}" method="POST" class="form-processo">

        <h1>Visualizar Processo</h1>

        @include('processos._form')

    </form>

    </div>

@endsection


