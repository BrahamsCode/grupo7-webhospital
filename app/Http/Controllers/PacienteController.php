<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Usuario;
use App\Models\SeguroMedico;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Muestra una lista de todos los pacientes activos.
     */
    public function index()
    {
        $pacientes = Paciente::where('estado_auditoria', '1')
            ->with(['usuario', 'seguroMedico'])
            ->get();

        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Muestra el formulario para crear un nuevo paciente.
     */
    public function create()
    {
        // Obtener usuarios con rol de paciente (id_rol = 2) que no están asignados a un paciente
        $usuarios = Usuario::where('estado_auditoria', '1')
            ->where('id_rol', 2)
            ->whereDoesntHave('paciente')
            ->get();

        $segurosMedicos = SeguroMedico::where('estado_auditoria', '1')->get();

        return view('pacientes.create', compact('usuarios', 'segurosMedicos'));
    }

    /**
     * Almacena un nuevo paciente en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario|unique:pacientes',
            'direccion' => 'required|string|max:150',
            'id_seguro_medico' => 'required|exists:seguros_medicos,id_seguro_medico',
        ]);

        Paciente::create($validatedData);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente creado exitosamente.');
    }

    /**
     * Muestra los detalles de un paciente específico.
     */
    public function show($id)
    {
        $paciente = Paciente::where('id_paciente', $id)
            ->where('estado_auditoria', '1')
            ->with(['usuario', 'seguroMedico', 'citas', 'historialClinico'])
            ->firstOrFail();

        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Muestra el formulario para editar un paciente existente.
     */
    public function edit($id)
    {
        $paciente = Paciente::where('id_paciente', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Usuarios con rol de paciente, incluido el asignado a este paciente
        $usuarios = Usuario::where('estado_auditoria', '1')
            ->where('id_rol', 2)
            ->where(function($query) use ($paciente) {
                $query->whereDoesntHave('paciente')
                      ->orWhere('id_usuario', $paciente->id_usuario);
            })
            ->get();

        $segurosMedicos = SeguroMedico::where('estado_auditoria', '1')->get();

        return view('pacientes.edit', compact('paciente', 'usuarios', 'segurosMedicos'));
    }

    /**
     * Actualiza un paciente específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::where('id_paciente', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario|unique:pacientes,id_usuario,'.$id.',id_paciente',
            'direccion' => 'required|string|max:150',
            'id_seguro_medico' => 'required|exists:seguros_medicos,id_seguro_medico',
        ]);

        $paciente->update($validatedData);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado exitosamente.');
    }

    /**
     * Elimina un paciente específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $paciente = Paciente::where('id_paciente', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $paciente->estado_auditoria = '0';
        $paciente->save();

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado exitosamente.');
    }
}
