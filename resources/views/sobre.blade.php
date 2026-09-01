@extends('layouts.app')

@section('title', 'Sobre Nós')

@section('content')

<link rel="stylesheet" href="{{ asset('css/sobre.css') }}">

<section class="sobre">

    <div class="sobre-conteudo">

        <span class="sobre-label">
            SOBRE NÓS
        </span>

        <h1>
            Tecnologia e estratégia<br>
            para escritórios que<br>
            querem <span>ir além.</span>
        </h1>

        <p>
            O Juris Control nasceu com o propósito de transformar
            a gestão jurídica por meio da tecnologia, da inovação e
            do compromisso com resultados.
        </p>

    </div>

</section>

@endsection
