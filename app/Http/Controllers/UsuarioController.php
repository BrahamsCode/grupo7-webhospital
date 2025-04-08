<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(){
        $usuarios = Usuario::where('estado_auditoria','1')->get();
        return view('usuarios', compact('usuarios'));
    }
}
