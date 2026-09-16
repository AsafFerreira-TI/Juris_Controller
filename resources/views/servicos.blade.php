@extends('layouts.app')

@section('title', 'Serviços')

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
<center>
<section class="solucoes">

    <div class="solucoes-cont">

        <span class="solucoes-lbl">
            Planos e preços
        </span>

        <h1>
            Mais controle, mais produtividade,<br>
            <span>mais crescimento para o seu negócio.</span>
        </h1>

            <table>
                <tr>
                    <td class="men">
                        <div class="mensal">
                            <label>Mensal</label>
                        </div>
                    </td>
                    <td class="sem">
                        <div class="semestral">
                            <label>Semestral <span>-10%</span></label>
                        </div>
                    </td>
                    <td class="an">
                        <div class="anual">
                            <label>Anual <span>-10%</span></label>
                        </div>
                    </td>
                </tr>
</table>



        <!--<p>
            O Juris Control nasceu com o propósito de transformar
            a gestão jurídica por meio da tecnologia, da inovação e
            do compromisso com resultados.
        </p> -->

    </div>
</center>
</section>

@endsection
