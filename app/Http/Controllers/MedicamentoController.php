<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicamentoController extends Controller
{
    /**
     * Muestra una lista de todos los medicamentos activos.
     */
    public function index()
    {
        $medicamentos = Medicamento::where('estado_auditoria', '1')->get();
        return view('medicamentos.index', compact('medicamentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo medicamento.
     */
    public function create()
    {
        return view('medicamentos.create');
    }

    /**
     * Almacena un nuevo medicamento en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'codigo_medicamento' => 'required|string|max:100|unique:medicamentos',
            'descripcion' => 'required|string',
            'presentacion' => 'required|string|max:255',
            'dosis_recomendada' => 'required|string|max:255',
            'fecha_vencimiento' => 'required|date|after:today',
            'laboratorio' => 'required|string|max:150',
            'stock' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
        ]);

        $medicamento = new Medicamento();
        $medicamento->nombre = $validatedData['nombre'];
        $medicamento->codigo_medicamento = $validatedData['codigo_medicamento'];
        $medicamento->descripcion = $validatedData['descripcion'];
        $medicamento->presentacion = $validatedData['presentacion'];
        $medicamento->dosis_recomendada = $validatedData['dosis_recomendada'];
        $medicamento->fecha_vencimiento = $validatedData['fecha_vencimiento'];
        $medicamento->laboratorio = $validatedData['laboratorio'];
        $medicamento->stock = $validatedData['stock'];
        $medicamento->precio = $validatedData['precio'];

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('medicamentos', 'public');
            $medicamento->imagen_url = Storage::url($path);
        }

        $medicamento->save();

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento creado exitosamente.');
    }

    /**
     * Muestra los detalles de un medicamento específico.
     */
    public function show($id)
    {
        $medicamento = Medicamento::where('id_medicamento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('medicamentos.show', compact('medicamento'));
    }

    /**
     * Muestra el formulario para editar un medicamento existente.
     */
    public function edit($id)
    {
        $medicamento = Medicamento::where('id_medicamento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        return view('medicamentos.edit', compact('medicamento'));
    }

    /**
     * Actualiza un medicamento específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $medicamento = Medicamento::where('id_medicamento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'codigo_medicamento' => 'required|string|max:100|unique:medicamentos,codigo_medicamento,'.$id.',id_medicamento',
            'descripcion' => 'required|string',
            'presentacion' => 'required|string|max:255',
            'dosis_recomendada' => 'required|string|max:255',
            'fecha_vencimiento' => 'required|date',
            'laboratorio' => 'required|string|max:150',
            'stock' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
        ]);

        $medicamento->nombre = $validatedData['nombre'];
        $medicamento->codigo_medicamento = $validatedData['codigo_medicamento'];
        $medicamento->descripcion = $validatedData['descripcion'];
        $medicamento->presentacion = $validatedData['presentacion'];
        $medicamento->dosis_recomendada = $validatedData['dosis_recomendada'];
        $medicamento->fecha_vencimiento = $validatedData['fecha_vencimiento'];
        $medicamento->laboratorio = $validatedData['laboratorio'];
        $medicamento->stock = $validatedData['stock'];
        $medicamento->precio = $validatedData['precio'];

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($medicamento->imagen_url) {
                $oldPath = str_replace('/storage', 'public', $medicamento->imagen_url);
                Storage::delete($oldPath);
            }

            $path = $request->file('imagen')->store('medicamentos', 'public');
            $medicamento->imagen_url = Storage::url($path);
        }

        $medicamento->save();

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento actualizado exitosamente.');
    }

    /**
     * Elimina un medicamento específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $medicamento = Medicamento::where('id_medicamento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $medicamento->estado_auditoria = '0';
        $medicamento->save();

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento eliminado exitosamente.');
    }

    /**
     * Actualiza el stock de un medicamento.
     */
    public function actualizarStock(Request $request, $id)
    {
        $medicamento = Medicamento::where('id_medicamento', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'cantidad' => 'required|integer',
            'tipo_movimiento' => 'required|in:entrada,salida',
        ]);

        if ($validatedData['tipo_movimiento'] == 'entrada') {
            $medicamento->stock += $validatedData['cantidad'];
        } else {
            // Verificar que haya suficiente stock
            if ($medicamento->stock < $validatedData['cantidad']) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }
            $medicamento->stock -= $validatedData['cantidad'];
        }

        $medicamento->save();

        return redirect()->route('medicamentos.show', $medicamento->id_medicamento)
            ->with('success', 'Stock actualizado exitosamente.');
    }
}
