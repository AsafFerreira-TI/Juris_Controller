<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        $titulo = 'Bem-vindo ao Juris Control';
        return view('home', compact('titulo'));
    }
}
