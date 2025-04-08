<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EspecialidadController extends Controller
{
    /**
     * Muestra una lista de todas las especialidades activas.
     */
    public function index()
    {
        $especialidades = Especialidad::where('estado_auditoria', '1')->get();
        return view('especialidades.index', compact('especialidades'));
    }

    /**
     * Muestra el formulario para crear una nueva especialidad.
     */
    public function create()
    {
        return view('especialidades.create');
    }

    /**
     * Almacena una nueva especialidad en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $especialidad = new Especialidad();
        $especialidad->nombre = $validatedData['nombre'];
        $especialidad->descripcion = $validatedData['descripcion'];

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('especialidades', 'public');
            $especialidad->imagen_url = Storage::url($path);
        }

        $especialidad->save();

        return redirect()->route('especialidades.index')
            ->with('success', 'Especialidad creada exitosamente.');
    }

    /**
     * Muestra los detalles de una especialidad específica.
     */
    public function show($id)
    {
        $especialidad = Especialidad::where('id_especialidad', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('especialidades.show', compact('especialidad'));
    }

    /**
     * Muestra el formulario para editar una especialidad existente.
     */
    public function edit($id)
    {
        $especialidad = Especialidad::where('id_especialidad', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('especialidades.edit', compact('especialidad'));
    }

    /**
     * Actualiza una especialidad específica en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $especialidad = Especialidad::where('id_especialidad', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $especialidad->nombre = $validatedData['nombre'];
        $especialidad->descripcion = $validatedData['descripcion'];

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($especialidad->imagen_url) {
                $oldPath = str_replace('/storage', 'public', $especialidad->imagen_url);
                Storage::delete($oldPath);
            }

            $path = $request->file('imagen')->store('especialidades', 'public');
            $especialidad->imagen_url = Storage::url($path);
        }

        $especialidad->save();

        return redirect()->route('especialidades.index')
            ->with('success', 'Especialidad actualizada exitosamente.');
    }

    /**
     * Elimina una especialidad específica (eliminación lógica).
     */
    public function destroy($id)
    {
        $especialidad = Especialidad::where('id_especialidad', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $especialidad->estado_auditoria = '0';
        $especialidad->save();

        return redirect()->route('especialidades.index')
            ->with('success', 'Especialidad eliminada exitosamente.');
    }
}
