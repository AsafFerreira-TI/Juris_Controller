@extends('layouts.app')

@section('title', 'Início')

@section('content')
 <div class="row gy-4 mb-5 ml-0">
<div class="py-6">
    <div class="position-relative">
        <div class="position-absolute fw-bold text-color-white">
           <h2> <span>No Juris Control você tem total controle do seu escritório</span></h2>
        </div>

    <img src="{{ asset('img/img_fundo_index.png') }}" width="100%">
</div>
</div>
</div>
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">{{ $titulo }}</h1>
            <p class="col-md-8 fs-5">
                Este é o início do sistema da Lanchonete. Nas próximas aulas,
                vamos construir o catálogo (categorias e produtos), pedidos e relatórios.
            </p>
            #Ver Cardápio</a>
        </div>
    </div>
@endsection
