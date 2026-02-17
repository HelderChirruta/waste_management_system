<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $credentials = [
    //         'email' => $request->email,
    //         'password' => $request->password,
    //     ];

    //     if (Auth::attempt($credentials, $request->remember)) {
    //         $request->session()->regenerate();

    //         $user = Auth::user();


    //         if ($user->role->nome == 'Administrador') {
    //             return redirect()->intended('/admin/dashboard');
    //         } elseif ($user->role->nome == 'Gestor') {
    //             return redirect()->intended('/gestor/dashboard');
    //         } else {
    //             return redirect()->intended('/operador/dashboard');
    //         }
    //     }

    //     return back()->withErrors([
    //         'email' => 'Credenciais inválidas.',
    //     ]);
    // }
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->role) {
                return back()->withErrors([
                    'email' => 'Usuário sem perfil associado.',
                ]);
            }

            if ($user->role->nome == 'Administrador') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role->nome == 'Gestor') {
                return redirect()->intended('/gestor/dashboard');
            } else {
                return redirect()->intended('/operador/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}