<?php

namespace App\Http\Controllers;

use App\Models\SeguroMedico;
use Illuminate\Http\Request;

class SeguroMedicoController extends Controller
{
    /**
     * Muestra una lista de todos los seguros médicos activos.
     */
    public function index()
    {
        $segurosMedicos = SeguroMedico::where('estado_auditoria', '1')->get();
        return view('seguros_medicos.index', compact('segurosMedicos'));
    }

    /**
     * Muestra el formulario para crear un nuevo seguro médico.
     */
    public function create()
    {
        return view('seguros_medicos.create');
    }

    /**
     * Almacena un nuevo seguro médico en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'tipo_plan' => 'required|string|max:150',
            'porcentaje_cobertura' => 'required|numeric|min:0|max:100',
        ]);

        SeguroMedico::create($validatedData);

        return redirect()->route('seguros_medicos.index')
            ->with('success', 'Seguro médico creado exitosamente.');
    }

    /**
     * Muestra los detalles de un seguro médico específico.
     */
    public function show($id)
    {
        $seguroMedico = SeguroMedico::where('id_seguro_medico', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('seguros_medicos.show', compact('seguroMedico'));
    }

    /**
     * Muestra el formulario para editar un seguro médico existente.
     */
    public function edit($id)
    {
        $seguroMedico = SeguroMedico::where('id_seguro_medico', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('seguros_medicos.edit', compact('seguroMedico'));
    }

    /**
     * Actualiza un seguro médico específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'tipo_plan' => 'required|string|max:150',
            'porcentaje_cobertura' => 'required|numeric|min:0|max:100',
        ]);

        $seguroMedico = SeguroMedico::where('id_seguro_medico', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $seguroMedico->update($validatedData);

        return redirect()->route('seguros_medicos.index')
            ->with('success', 'Seguro médico actualizado exitosamente.');
    }

    /**
     * Elimina un seguro médico específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $seguroMedico = SeguroMedico::where('id_seguro_medico', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $seguroMedico->estado_auditoria = '0';
        $seguroMedico->save();

        return redirect()->route('seguros_medicos.index')
            ->with('success', 'Seguro médico eliminado exitosamente.');
    }
}
