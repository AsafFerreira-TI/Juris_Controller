<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
        {
            $titulo = 'Perfil';
            return view('perfil', compact('titulo'));
        }
}
