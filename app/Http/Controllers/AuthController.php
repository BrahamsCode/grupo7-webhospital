<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesa el login
    public function login(Request $request)
    {
        $credentials = $request->only('usuario', 'password');

        if (Auth::attempt(['name' => $credentials['usuario'], 'password' => $credentials['password']])) {
            return redirect()->route('home');
        }

        return back()->withErrors(['usuario' => 'Credenciales incorrectas']);
    }
}
