<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    /**
     * Muestra una lista de todas las habitaciones activas.
     */
    public function index()
    {
        $habitaciones = Habitacion::where('estado_auditoria', '1')->get();
        return view('habitaciones.index', compact('habitaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva habitación.
     */
    public function create()
    {
        return view('habitaciones.create');
    }

    /**
     * Almacena una nueva habitación en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero' => 'required|string|max:5|unique:habitaciones',
            'tipo_habitacion' => 'required|string|size:1',
            'estado_habitacion' => 'required|string|size:1',
            'observacion' => 'nullable|string',
        ]);

        Habitacion::create($validatedData);

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación creada exitosamente.');
    }

    /**
     * Muestra los detalles de una habitación específica.
     */
    public function show($id)
    {
        $habitacion = Habitacion::where('id_habitacion', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('habitaciones.show', compact('habitacion'));
    }

    /**
     * Muestra el formulario para editar una habitación existente.
     */
    public function edit($id)
    {
        $habitacion = Habitacion::where('id_habitacion', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('habitaciones.edit', compact('habitacion'));
    }

    /**
     * Actualiza una habitación específica en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $habitacion = Habitacion::where('id_habitacion', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'numero' => 'required|string|max:5|unique:habitaciones,numero,'.$id.',id_habitacion',
            'tipo_habitacion' => 'required|string|size:1',
            'estado_habitacion' => 'required|string|size:1',
            'observacion' => 'nullable|string',
        ]);

        $habitacion->update($validatedData);

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación actualizada exitosamente.');
    }

    /**
     * Elimina una habitación específica (eliminación lógica).
     */
    public function destroy($id)
    {
        $habitacion = Habitacion::where('id_habitacion', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $habitacion->estado_auditoria = '0';
        $habitacion->save();

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación eliminada exitosamente.');
    }

    /**
     * Cambia el estado de una habitación.
     */
    public function cambiarEstado(Request $request, $id)
    {
        $validatedData = $request->validate([
            'estado_habitacion' => 'required|string|size:1',
            'observacion' => 'nullable|string',
        ]);

        $habitacion = Habitacion::where('id_habitacion', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $habitacion->estado_habitacion = $validatedData['estado_habitacion'];
        $habitacion->observacion = $validatedData['observacion'];
        $habitacion->save();

        return redirect()->route('habitaciones.index')
            ->with('success', 'Estado de la habitación actualizado exitosamente.');
    }
}
