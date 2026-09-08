<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolucoesController extends Controller
{
     public function index()
        {
            $titulo = 'Nossos Serviços';
            return view('solucoes', compact('titulo'));
        }
}
