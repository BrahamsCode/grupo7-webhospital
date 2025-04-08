<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(){
        $usuarios = Usuario::with('especialidad')
                            ->where('estado_auditoria','1')
                            ->get();
        return view('usuarios', compact('usuarios'));
    }

    public function doctores(){
    $doctores = Usuario::with('especialidad')
                       ->where('estado_auditoria', '1')
                       ->where('id_rol', 3)
                       ->get();
    return view('doctores', compact('doctores'));
    }
}
