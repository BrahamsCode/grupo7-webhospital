<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function index(){
        $especialidades = Especialidad::where('estado_auditoria','1')->get();
        return view('especialidades', compact('especialidades'));
    }
}
