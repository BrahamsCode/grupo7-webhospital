<?php

namespace App\Http\Controllers;

use App\Models\RecetaMedica;
use App\Models\Cita;
use App\Models\Medicamento;
use App\Models\DetalleReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RecetaMedicaController extends Controller
{
    /**
     * Muestra una lista de todas las recetas médicas activas.
     */
    public function index()
    {
        $recetasMedicas = RecetaMedica::where('estado_auditoria', '1')
            ->with(['cita.paciente.usuario', 'cita.doctor'])
            ->get();

        return view('recetas_medicas.index', compact('recetasMedicas'));
    }

    /**
     * Muestra el formulario para crear una nueva receta médica.
     */
    public function create()
    {
        $citas = Cita::where('estado_auditoria', '1')
            ->where('estado', 'C') // Citas completadas
            ->with(['paciente.usuario', 'doctor'])
            ->get();

        $medicamentos = Medicamento::where('estado_auditoria', '1')
            ->where('stock', '>', 0)
            ->get();

        return view('recetas_medicas.create', compact('citas', 'medicamentos'));
    }

    /**
     * Almacena una nueva receta médica en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_cita' => 'required|exists:citas,id_cita',
            'instrucciones' => 'nullable|string',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.id_medicamento' => 'required|exists:medicamentos,id_medicamento',
            'medicamentos.*.cantidad' => 'required|integer|min:1',
            'medicamentos.*.dosis' => 'required|string',
            'medicamentos.*.frecuencia' => 'required|string',
            'medicamentos.*.duracion' => 'required|string',
        ]);

        // Crear la receta
        $receta = new RecetaMedica();
        $receta->id_cita = $validatedData['id_cita'];
        $receta->fecha_emision = Carbon::now();
        $receta->estado = 'A'; // A = Activa
        $receta->instrucciones = $validatedData['instrucciones'];
        $receta->save();

        // Crear los detalles de la receta
        foreach ($validatedData['medicamentos'] as $med) {
            $detalle = new DetalleReceta();
            $detalle->id_receta = $receta->id_receta;
            $detalle->id_medicamento = $med['id_medicamento'];
            $detalle->cantidad = $med['cantidad'];
            $detalle->dosis = $med['dosis'];
            $detalle->frecuencia = $med['frecuencia'];
            $detalle->duracion = $med['duracion'];
            $detalle->save();

            // Actualizar stock del medicamento
            $medicamento = Medicamento::find($med['id_medicamento']);
            $medicamento->stock -= $med['cantidad'];
            $medicamento->save();
        }

        return redirect()->route('recetas_medicas.show', $receta->id_receta)
            ->with('success', 'Receta médica creada exitosamente.');
    }

    /**
     * Muestra los detalles de una receta médica específica.
     */
    public function show($id)
    {
        $recetaMedica = RecetaMedica::where('id_receta', $id)
            ->where('estado_auditoria', '1')
            ->with(['cita.paciente.usuario', 'cita.doctor', 'detallesReceta.medicamento'])
            ->firstOrFail();

        return view('recetas_medicas.show', compact('recetaMedica'));
    }

    /**
     * Muestra el formulario para editar una receta médica existente.
     */
    public function edit($id)
    {
        $recetaMedica = RecetaMedica::where('id_receta', $id)
            ->where('estado_auditoria', '1')
            ->with('detallesReceta.medicamento')
            ->firstOrFail();

        $citas = Cita::where('estado_auditoria', '1')
            ->where('estado', 'C') // Citas completadas
            ->with(['paciente.usuario', 'doctor'])
            ->get();

        $medicamentos = Medicamento::where('estado_auditoria', '1')
            ->where('stock', '>', 0)
            ->get();

        return view('recetas_medicas.edit', compact('recetaMedica', 'citas', 'medicamentos'));
    }

    /**
     * Actualiza una receta médica específica en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $recetaMedica = RecetaMedica::where('id_receta', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'id_cita' => 'required|exists:citas,id_cita',
            'instrucciones' => 'nullable|string',
            'estado' => 'required|string|size:1',
        ]);

        $recetaMedica->update($validatedData);

        return redirect()->route('recetas_medicas.index')
            ->with('success', 'Receta médica actualizada exitosamente.');
    }

    /**
     * Elimina una receta médica específica (eliminación lógica).
     */
    public function destroy($id)
    {
        $recetaMedica = RecetaMedica::where('id_receta', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $recetaMedica->estado_auditoria = '0';
        $recetaMedica->save();

        return redirect()->route('recetas_medicas.index')
            ->with('success', 'Receta médica eliminada exitosamente.');
    }

    /**
     * Genera un PDF de la receta médica.
     */
    public function generarPDF($id)
    {
        $recetaMedica = RecetaMedica::where('id_receta', $id)
            ->where('estado_auditoria', '1')
            ->with(['cita.paciente.usuario', 'cita.doctor', 'detallesReceta.medicamento'])
            ->firstOrFail();

        // Aquí se generaría el PDF usando una librería como DOMPDF
        // Por ejemplo:
        // $pdf = PDF::loadView('recetas_medicas.pdf', compact('recetaMedica'));
        // return $pdf->download('receta_'.$id.'.pdf');

        // Por ahora, simplemente redireccionamos a la vista de la receta
        return view('recetas_medicas.pdf', compact('recetaMedica'));
    }
}
