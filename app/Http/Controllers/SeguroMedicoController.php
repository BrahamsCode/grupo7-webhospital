<?php

namespace App\Http\Controllers;

use App\Models\SeguroMedico;
use Illuminate\Http\Request;

class SeguroMedicoController extends Controller
{
    public function index(){
        $seguros = SeguroMedico::where('estado_auditoria', '1')->get();
        return view('seguromedico', compact('seguros'));
    }
}
