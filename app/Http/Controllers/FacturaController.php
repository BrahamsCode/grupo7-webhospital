<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Medicamento;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FacturaController extends Controller
{
    /**
     * Muestra una lista de todas las facturas activas.
     */
    public function index()
    {
        $facturas = Factura::where('estado_auditoria', '1')
            ->with('paciente.usuario')
            ->get();

        return view('facturas.index', compact('facturas'));
    }

    /**
     * Muestra el formulario para crear una nueva factura.
     */
    public function create()
    {
        $pacientes = Paciente::where('estado_auditoria', '1')
            ->with(['usuario', 'seguroMedico'])
            ->get();

        $citas = Cita::where('estado_auditoria', '1')
            ->where('estado', 'C') // Completadas
            ->with(['paciente.usuario', 'doctor'])
            ->get();

        $medicamentos = Medicamento::where('estado_auditoria', '1')
            ->where('stock', '>', 0)
            ->get();

        $tratamientos = Tratamiento::where('estado_auditoria', '1')->get();

        return view('facturas.create', compact('pacientes', 'citas', 'medicamentos', 'tratamientos'));
    }

    /**
     * Almacena una nueva factura en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'items' => 'required|array|min:1',
            'items.*.concepto' => 'required|string',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.tipo' => 'required|string|size:1',
            'items.*.id_referencia' => 'nullable|integer',
        ]);

        // Obtener información del paciente y su seguro
        $paciente = Paciente::with('seguroMedico')
            ->where('id_paciente', $validatedData['id_paciente'])
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Calcular montos
        $montoTotal = 0;
        foreach ($validatedData['items'] as $item) {
            $montoTotal += $item['cantidad'] * $item['precio_unitario'];
        }

        // Calcular descuento por seguro
        $porcentajeCobertura = $paciente->seguroMedico ? $paciente->seguroMedico->porcentaje_cobertura : 0;
        $montoSeguro = ($montoTotal * $porcentajeCobertura) / 100;
        $montoFinal = $montoTotal - $montoSeguro;

        // Crear la factura
        $factura = new Factura();
        $factura->id_paciente = $validatedData['id_paciente'];
        $factura->fecha_emision = Carbon::now();
        $factura->monto_total = $montoTotal;
        $factura->monto_seguro = $montoSeguro;
        $factura->monto_final = $montoFinal;
        $factura->estado = 'P'; // P = Pendiente
        $factura->save();

        // Crear los detalles de la factura
        foreach ($validatedData['items'] as $item) {
            $detalle = new DetalleFactura();
            $detalle->id_factura = $factura->id_factura;
            $detalle->concepto = $item['concepto'];
            $detalle->cantidad = $item['cantidad'];
            $detalle->precio_unitario = $item['precio_unitario'];
            $detalle->subtotal = $item['cantidad'] * $item['precio_unitario'];
            $detalle->tipo = $item['tipo'];
            $detalle->id_referencia = $item['id_referencia'];
            $detalle->save();

            // Si es un medicamento, actualizar stock
            if ($item['tipo'] == 'M' && $item['id_referencia']) {
                $medicamento = Medicamento::find($item['id_referencia']);
                if ($medicamento) {
                    $medicamento->stock -= $item['cantidad'];
                    $medicamento->save();
                }
            }
        }

        return redirect()->route('facturas.show', $factura->id_factura)
            ->with('success', 'Factura creada exitosamente.');
    }

    /**
     * Muestra los detalles de una factura específica.
     */
    public function show($id)
    {
        $factura = Factura::where('id_factura', $id)
            ->where('estado_auditoria', '1')
            ->with(['paciente.usuario', 'paciente.seguroMedico', 'detallesFactura', 'pagos'])
            ->firstOrFail();

        return view('facturas.show', compact('factura'));
    }

    /**
     * Elimina una factura específica (eliminación lógica).
     */
    public function destroy($id)
    {
        $factura = Factura::where('id_factura', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $factura->estado_auditoria = '0';
        $factura->save();

        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada exitosamente.');
    }

    /**
     * Genera un PDF de la factura.
     */
    public function generarPDF($id)
    {
        $factura = Factura::where('id_factura', $id)
            ->where('estado_auditoria', '1')
            ->with(['paciente.usuario', 'paciente.seguroMedico', 'detallesFactura', 'pagos'])
            ->firstOrFail();

        // Aquí se generaría el PDF usando una librería como DOMPDF
        // Por ejemplo:
        // $pdf = PDF::loadView('facturas.pdf', compact('factura'));
        // return $pdf->download('factura_'.$id.'.pdf');

        // Por ahora, simplemente redireccionamos a la vista de la factura
        return view('facturas.pdf', compact('factura'));
    }
}
