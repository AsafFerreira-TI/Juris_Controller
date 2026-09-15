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
        $data = $request->validate([
            'nome_advg' => ['required', 'string', 'max:255'],
            'oab_advg' => ['required', 'string', 'max:50'],
            'email_advg' => ['required', 'email', 'max:255', 'unique:users,email_advg'],
            'cpf_advg' => ['required', 'string', 'max:20'],
            'telefone_advg' => ['required', 'string', 'max:20'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'nome_advg' => $data['nome_advg'],
            'oab_advg' => $data['oab_advg'],
            'email_advg' => $data['email_advg'],
            'cpf_advg' => $data['cpf_advg'],
            'telefone_advg' => $data['telefone_advg'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Conta criada com sucesso.');
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

            return redirect()->intended(route('dashboard'));
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
