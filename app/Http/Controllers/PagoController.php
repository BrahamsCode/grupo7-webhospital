<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PagoController extends Controller
{
    /**
     * Muestra una lista de todos los pagos activos.
     */
    public function index()
    {
        $pagos = Pago::where('estado_auditoria', '1')
            ->with('factura.paciente.usuario')
            ->get();

        return view('pagos.index', compact('pagos'));
    }

    /**
     * Muestra el formulario para crear un nuevo pago.
     */
    public function create()
    {
        $facturas = Factura::where('estado_auditoria', '1')
            ->where('estado', 'P') // Pendiente
            ->with('paciente.usuario')
            ->get();

        return view('pagos.create', compact('facturas'));
    }

    /**
     * Registra un pago para una factura específica.
     */
    public function registrarPago(Request $request, $id_factura)
    {
        $factura = Factura::where('id_factura', $id_factura)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'monto' => 'required|numeric|min:0.01|max:' . $factura->monto_final,
            'metodo_pago' => 'required|string|max:255',
            'referencia_pago' => 'nullable|string|max:255',
        ]);

        // Crear el pago
        $pago = new Pago();
        $pago->id_factura = $factura->id_factura;
        $pago->fecha_pago = Carbon::now();
        $pago->monto = $validatedData['monto'];
        $pago->metodo_pago = $validatedData['metodo_pago'];
        $pago->referencia_pago = $validatedData['referencia_pago'];
        $pago->estado = 'A'; // A = Aprobado
        $pago->save();

        // Verificar si la factura ha sido pagada completamente
        $totalPagado = Pago::where('id_factura', $factura->id_factura)
            ->where('estado', 'A')
            ->where('estado_auditoria', '1')
            ->sum('monto');

        if ($totalPagado >= $factura->monto_final) {
            $factura->estado = 'C'; // C = Completada
            $factura->save();
        }

        return redirect()->route('facturas.show', $factura->id_factura)
            ->with('success', 'Pago registrado exitosamente.');
    }

    /**
     * Muestra los detalles de un pago específico.
     */
    public function show($id)
    {
        $pago = Pago::where('id_pago', $id)
            ->where('estado_auditoria', '1')
            ->with('factura.paciente.usuario')
            ->firstOrFail();

        return view('pagos.show', compact('pago'));
    }

    /**
     * Anula un pago específico.
     */
    public function anular($id)
    {
        $pago = Pago::where('id_pago', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Anular el pago
        $pago->estado = 'N'; // N = Anulado
        $pago->save();

        // Actualizar estado de la factura
        $factura = Factura::find($pago->id_factura);
        $factura->estado = 'P'; // P = Pendiente
        $factura->save();

        return redirect()->route('facturas.show', $factura->id_factura)
            ->with('success', 'Pago anulado exitosamente.');
    }

    /**
     * Elimina un pago específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $pago = Pago::where('id_pago', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $pago->estado_auditoria = '0';
        $pago->save();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado exitosamente.');
    }
}
