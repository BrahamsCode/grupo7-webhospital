<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request){
        $query = Usuario::where('estado_auditoria', '1');

        if ($request->has('rol') && $request->get('rol') != '') {
            $query->where('id_rol', $request->get('rol'));
        }

        $usuarios = $query->get();
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
