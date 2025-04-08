<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Muestra una lista de todos los roles activos.
     */
    public function index()
    {
        $roles = Rol::where('estado_auditoria', '1')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Muestra el formulario para crear un nuevo rol.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Almacena un nuevo rol en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:150',
        ]);

        // Por defecto, estado_auditoria será '1'
        Rol::create($validatedData);

        return redirect()->route('roles.index')
            ->with('success', 'Rol creado exitosamente.');
    }

    /**
     * Muestra los detalles de un rol específico.
     */
    public function show($id)
    {
        $rol = Rol::where('id_rol', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('roles.show', compact('rol'));
    }

    /**
     * Muestra el formulario para editar un rol existente.
     */
    public function edit($id)
    {
        $rol = Rol::where('id_rol', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('roles.edit', compact('rol'));
    }

    /**
     * Actualiza un rol específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:150',
        ]);

        $rol = Rol::where('id_rol', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();
        
        $rol->update($validatedData);

        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado exitosamente.');
    }

    /**
     * Elimina un rol específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $rol = Rol::where('id_rol', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $rol->estado_auditoria = '0';
        $rol->save();

        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado exitosamente.');
    }
}
