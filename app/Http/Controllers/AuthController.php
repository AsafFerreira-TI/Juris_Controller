<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
       $dados = $request->validate([
            'nome_advg' => 'required|string|max:100',
            'oab_advg' => 'required|string|max:20|unique:users,oab_advg',
            'email_advg' => 'required|email|max:255|unique:users,email_advg',
            'cpf_advg' => 'required|string|max:14|unique:users,cpf_advg',
            'telefone_advg' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'nome_advg' => $dados['nome_advg'],
            'oab_advg' => $dados['oab_advg'],
            'email_advg' => $dados['email_advg'],
            'cpf_advg' => $dados['cpf_advg'],
            'telefone_advg' => $dados['telefone_advg'],
            'password' => Hash::make($dados['password']),
        ]);

        return redirect()->route('home')
            ->with('sucesso', 'Produto criado com sucesso!');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email_advg' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            return redirect()
            ->route('processos.index')
            ->with('sucesso', 'Login efetuado com sucesso!');

        }

        return back()
            ->withErrors([
                'email_advg' => 'E-mail ou senha incorretos.'
            ])
            ->onlyInput('email_advg');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
