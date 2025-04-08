
<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    /**
     * Muestra una lista de todos los tratamientos activos.
     */
    public function index()
    {
        $tratamientos = Tratamiento::where('estado_auditoria', '1')->get();
        return view('tratamientos.index', compact('tratamientos'));
    }

    /**
     * Muestra el formulario para crear un nuevo tratamiento.
     */
    public function create()
    {
        return view('tratamientos.create');
    }

    /**
     * Almacena un nuevo tratamiento en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'costo' => 'required|numeric|min:0',
        ]);

        Tratamiento::create($validatedData);

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento creado exitosamente.');
    }

    /**
     * Muestra los detalles de un tratamiento específico.
     */
    public function show($id)
    {
        $tratamiento = Tratamiento::where('id_tratamiento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('tratamientos.show', compact('tratamiento'));
    }

    /**
     * Muestra el formulario para editar un tratamiento existente.
     */
    public function edit($id)
    {
        $tratamiento = Tratamiento::where('id_tratamiento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('tratamientos.edit', compact('tratamiento'));
    }

    /**
     * Actualiza un tratamiento específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $tratamiento = Tratamiento::where('id_tratamiento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'costo' => 'required|numeric|min:0',
        ]);

        $tratamiento->update($validatedData);

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento actualizado exitosamente.');
    }

    /**
     * Elimina un tratamiento específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $tratamiento = Tratamiento::where('id_tratamiento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $tratamiento->estado_auditoria = '0';
        $tratamiento->save();

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento eliminado exitosamente.');
    }
}
