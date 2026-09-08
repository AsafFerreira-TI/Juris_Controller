@extends('layouts.app')

@section('title', 'Soluções')

@section('content')

<link rel="stylesheet" href="{{ asset('css/solucoes.css') }}">

<section class="solucoes-img">

    <div class="solucoes-conteudo">

        <span class="solucoes-label">
            NOSSOS SERVIÇOS
        </span>

        <h1>
            Planos que se adaptam<br>
            <span>ao seu escritório</span>
        </h1>

        <p>
            Melhoria na eficiencia do seu trablaho, reducao de
            erros operacionais, evitando a perda de prazos
            importantes.
        </p>

    </div>

</section>
<section class="solucoes">

    <div class="solucoes-cont">

        <span class="solucoes-lbl">
            Planos e preços
        </span>

        <h1>
            Mais controle, mais produtividade,<br>
            <span>mais crescimento para o seu negócio.</span>
        </h1>

        <div class="planos">
            <div class="mensal">
                <p class="men">Mensal</p>
            </div>
            <div class="semestral">
                <p class="sem">Semestral <span>-10%</span></p>
            </div>
            <div class="anual">
                <p class="an">Anual <span>-10%</span></p>
            </div>
        </div>
        <!--<p>
            O Juris Control nasceu com o propósito de transformar
            a gestão jurídica por meio da tecnologia, da inovação e
            do compromisso com resultados.
        </p> -->

    </div>

</section>

@endsection
