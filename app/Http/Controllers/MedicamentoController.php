<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index(){
        $medicamentos = Medicamento::where('estado_auditoria','1')->get();
        return view('medicamentos', compact('medicamentos'));
    }
}
