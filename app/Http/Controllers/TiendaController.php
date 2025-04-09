<?php
// app/Http/Controllers/TiendaController.php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index()
    {
        // Obtener medicamentos disponibles para venta
        $medicamentos = Medicamento::where('estado_auditoria', '1')
            ->where('stock', '>', 0)
            ->get();

        return view('tienda.landing', compact('medicamentos'));
    }

    public function verCarrito()
    {
        // Obtener carrito de la sesión
        $carrito = session()->get('carrito', []);
        $total = 0;

        // Si hay productos en el carrito, cargar sus detalles y calcular total
        $itemsCarrito = [];
        if (!empty($carrito)) {
            foreach ($carrito as $id => $item) {
                $medicamento = Medicamento::find($id);
                if ($medicamento) {
                    $itemsCarrito[] = [
                        'medicamento' => $medicamento,
                        'cantidad' => $item['cantidad']
                    ];
                    $total += $medicamento->precio * $item['cantidad'];
                }
            }
        }

        return view('tienda.carrito', compact('itemsCarrito', 'total'));
    }

    public function agregarAlCarrito(Request $request)
    {
        $id = $request->id;
        $cantidad = $request->cantidad ?? 1;

        // Verificar si el medicamento existe y tiene stock
        $medicamento = Medicamento::where('id_medicamento', $id)
            ->where('estado_auditoria', '1')
            ->where('stock', '>=', $cantidad)
            ->first();

        if (!$medicamento) {
            return response()->json(['error' => 'Producto no disponible'], 400);
        }

        // Obtener el carrito actual
        $carrito = session()->get('carrito', []);

        // Si el producto ya está en el carrito, actualizar cantidad
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            // Si no, agregar como nuevo
            $carrito[$id] = [
                'nombre' => $medicamento->nombre,
                'precio' => $medicamento->precio,
                'cantidad' => $cantidad
            ];
        }

        // Guardar carrito en sesión
        session()->put('carrito', $carrito);

        return response()->json([
            'success' => true,
            'mensaje' => 'Producto agregado al carrito',
            'carrito_count' => count(session('carrito', [])),
        ]);
    }

    public function eliminarDelCarrito(Request $request)
    {
        $id = $request->id;

        // Obtener el carrito actual
        $carrito = session()->get('carrito', []);

        // Eliminar el producto del carrito
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('tienda.carrito')
            ->with('success', 'Producto eliminado del carrito');
    }

    public function actualizarCarrito(Request $request)
    {
        $id = $request->id;
        $cantidad = $request->cantidad;

        // Validar cantidad
        if ($cantidad < 1) {
            return redirect()->route('tienda.carrito')
                ->with('error', 'La cantidad debe ser al menos 1');
        }

        // Verificar stock disponible
        $medicamento = Medicamento::where('id_medicamento', $id)
            ->where('estado_auditoria', '1')
            ->first();

        if (!$medicamento || $medicamento->stock < $cantidad) {
            return redirect()->route('tienda.carrito')
                ->with('error', 'No hay suficiente stock disponible');
        }

        // Actualizar cantidad en el carrito
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad;
            session()->put('carrito', $carrito);
        }

        return redirect()->route('tienda.carrito')
            ->with('success', 'Carrito actualizado');
    }

    public function finalizarCompra(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('tienda.carrito')
                ->with('error', 'No hay productos en el carrito');
        }

        // Esta sería la lógica para guardar la compra en la base de datos
        // En un sistema real, aquí se procesaría el pago, se actualizaría el stock, etc.

        // Para este ejemplo académico, simplemente limpiaremos el carrito
        session()->forget('carrito');

        return redirect()->route('tienda.index')
            ->with('success', 'Compra finalizada exitosamente. ¡Gracias por su compra!');
    }

    public function vaciarCarrito()
    {
        session()->forget('carrito');

        return redirect()->route('tienda.carrito')
            ->with('success', 'Carrito vaciado exitosamente');
    }
}
