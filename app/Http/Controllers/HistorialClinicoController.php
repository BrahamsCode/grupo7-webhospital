<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    /**
     * Muestra el historial clínico de un paciente específico.
     */
    public function show($idPaciente)
    {
        $paciente = Paciente::where('id_paciente', $idPaciente)
            ->where('estado_auditoria', '1')
            ->with('usuario')
            ->firstOrFail();

        $historial = HistorialClinico::where('id_paciente', $idPaciente)
            ->where('estado_auditoria', '1')
            ->with(['cita', 'tratamiento'])
            ->orderBy('fecha_creacion_auditoria', 'desc')
            ->get();

        $citas = Cita::where('id_paciente', $idPaciente)
            ->where('estado_auditoria', '1')
            ->where('estado', 'C') // Completadas
            ->with('doctor')
            ->orderBy('fecha_cita', 'desc')
            ->get();

        return view('historial_clinico.show', compact('paciente', 'historial', 'citas'));
    }

    /**
     * Muestra el formulario para agregar una nueva entrada al historial.
     */
    public function create($idPaciente)
    {
        $paciente = Paciente::where('id_paciente', $idPaciente)
            ->where('estado_auditoria', '1')
            ->with('usuario')
            ->firstOrFail();

        $citas = Cita::where('id_paciente', $idPaciente)
            ->where('estado_auditoria', '1')
            ->where('estado', 'C') // Completadas
            ->with('doctor')
            ->get();

        $tratamientos = Tratamiento::where('estado_auditoria', '1')->get();

        return view('historial_clinico.create', compact('paciente', 'citas', 'tratamientos'));
    }

    /**
     * Almacena una nueva entrada en el historial clínico.
     */
    public function store(Request $request, $idPaciente)
    {
        $validatedData = $request->validate([
            'id_cita' => 'nullable|exists:citas,id_cita',
            'id_tratamiento' => 'nullable|exists:tratamientos,id_tratamiento',
            'notas' => 'required|string',
        ]);

        $historial = new HistorialClinico();
        $historial->id_paciente = $idPaciente;
        $historial->id_cita = $validatedData['id_cita'];
        $historial->id_tratamiento = $validatedData['id_tratamiento'];
        $historial->notas = $validatedData['notas'];
        $historial->save();

        return redirect()->route('historial_clinico.show', $idPaciente)
            ->with('success', 'Entrada agregada al historial clínico exitosamente.');
    }

    /**
     * Muestra el formulario para editar una entrada del historial.
     */
    public function edit($id)
    {
        $historial = HistorialClinico::where('id_historial', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $paciente = Paciente::where('id_paciente', $historial->id_paciente)
            ->with('usuario')
            ->firstOrFail();

        $citas = Cita::where('id_paciente', $historial->id_paciente)
            ->where('estado_auditoria', '1')
            ->where('estado', 'C') // Completadas
            ->with('doctor')
            ->get();

        $tratamientos = Tratamiento::where('estado_auditoria', '1')->get();

        return view('historial_clinico.edit', compact('historial', 'paciente', 'citas', 'tratamientos'));
    }

    /**
     * Actualiza una entrada específica del historial clínico.
     */
    public function update(Request $request, $id)
    {
        $historial = HistorialClinico::where('id_historial', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'id_cita' => 'nullable|exists:citas,id_cita',
            'id_tratamiento' => 'nullable|exists:tratamientos,id_tratamiento',
            'notas' => 'required|string',
        ]);

        $historial->update($validatedData);

        return redirect()->route('historial_clinico.show', $historial->id_paciente)
            ->with('success', 'Entrada del historial clínico actualizada exitosamente.');
    }

    /**
     * Elimina una entrada específica del historial clínico (eliminación lógica).
     */
    public function destroy($id)
    {
        $historial = HistorialClinico::where('id_historial', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $idPaciente = $historial->id_paciente;

        // Eliminación lógica
        $historial->estado_auditoria = '0';
        $historial->save();

        return redirect()->route('historial_clinico.show', $idPaciente)
            ->with('success', 'Entrada del historial clínico eliminada exitosamente.');
    }
}
