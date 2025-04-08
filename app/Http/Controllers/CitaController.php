<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Muestra una lista de todas las citas activas.
     */
    public function index()
    {
        $citas = Cita::where('estado_auditoria', '1')
            ->with(['paciente.usuario', 'doctor'])
            ->get();

        return view('citas.index', compact('citas'));
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function create()
    {
        $pacientes = Paciente::where('estado_auditoria', '1')
            ->with('usuario')
            ->get();

        $doctores = Usuario::where('estado_auditoria', '1')
            ->where('id_rol', 3) // Rol de doctor
            ->get();

        return view('citas.create', compact('pacientes', 'doctores'));
    }

    /**
     * Almacena una nueva cita en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_usuario_doctor' => 'required|exists:usuarios,id_usuario',
            'fecha_cita' => 'required|date_format:Y-m-d H:i:s|after:now',
            'estado' => 'required|string|size:1',
            'notas' => 'nullable|string',
        ]);

        Cita::create($validatedData);

        return redirect()->route('citas.index')
            ->with('success', 'Cita creada exitosamente.');
    }

    /**
     * Muestra los detalles de una cita específica.
     */
    public function show($id)
    {
        $cita = Cita::where('id_cita', $id)
            ->where('estado_auditoria', '1')
            ->with(['paciente.usuario', 'doctor', 'recetasMedicas.detallesReceta.medicamento'])
            ->firstOrFail();

        return view('citas.show', compact('cita'));
    }

    /**
     * Muestra el formulario para editar una cita existente.
     */
    public function edit($id)
    {
        $cita = Cita::where('id_cita', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $pacientes = Paciente::where('estado_auditoria', '1')
            ->with('usuario')
            ->get();

        $doctores = Usuario::where('estado_auditoria', '1')
            ->where('id_rol', 3) // Rol de doctor
            ->get();

        return view('citas.edit', compact('cita', 'pacientes', 'doctores'));
    }

    /**
     * Actualiza una cita específica en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_usuario_doctor' => 'required|exists:usuarios,id_usuario',
            'fecha_cita' => 'required|date_format:Y-m-d H:i:s',
            'estado' => 'required|string|size:1',
            'notas' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $cita = Cita::where('id_cita', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $cita->update($validatedData);

        return redirect()->route('citas.index')
            ->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Elimina una cita específica (eliminación lógica).
     */
    public function destroy($id)
    {
        $cita = Cita::where('id_cita', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $cita->estado_auditoria = '0';
        $cita->save();

        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }

    /**
     * Completa la información médica después de la consulta.
     */
    public function completarConsulta(Request $request, $id)
    {
        $validatedData = $request->validate([
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        $cita = Cita::where('id_cita', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $cita->diagnostico = $validatedData['diagnostico'];
        $cita->tratamiento = $validatedData['tratamiento'];
        $cita->observaciones = $validatedData['observaciones'];
        $cita->estado = 'C'; // C = Completada
        $cita->save();

        return redirect()->route('citas.show', $cita->id_cita)
            ->with('success', 'Consulta completada exitosamente.');
    }
}
