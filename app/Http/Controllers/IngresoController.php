

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Paciente;
use App\Models\Habitacion;
use Illuminate\Support\Carbon;

class IngresoController extends Controller
{
    /**
     * Muestra una lista de todos los ingresos activos.
     */
    public function index()
    {
        $ingresos = Ingreso::where('estado_auditoria', '1')
            ->with(['paciente.usuario', 'habitacion'])
            ->get();

        return view('ingresos.index', compact('ingresos'));
    }

    /**
     * Muestra el formulario para crear un nuevo ingreso.
     */
    public function create()
    {
        $pacientes = Paciente::where('estado_auditoria', '1')
            ->with('usuario')
            ->get();

        $habitaciones = Habitacion::where('estado_auditoria', '1')
            ->where('estado_habitacion', 'D') // D = Disponible
            ->get();

        return view('ingresos.create', compact('pacientes', 'habitaciones'));
    }

    /**
     * Almacena un nuevo ingreso en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_habitacion' => 'required|exists:habitaciones,id_habitacion',
            'fecha_ingreso' => 'required|date_format:Y-m-d H:i:s|before_or_equal:now',
            'motivo_ingreso' => 'required|string',
        ]);

        // Verificar que la habitación esté disponible
        $habitacion = Habitacion::find($validatedData['id_habitacion']);
        if ($habitacion->estado_habitacion != 'D') {
            return back()->withErrors(['id_habitacion' => 'La habitación seleccionada no está disponible.']);
        }

        // Crear el ingreso
        $ingreso = new Ingreso();
        $ingreso->id_paciente = $validatedData['id_paciente'];
        $ingreso->id_habitacion = $validatedData['id_habitacion'];
        $ingreso->fecha_ingreso = $validatedData['fecha_ingreso'];
        $ingreso->motivo_ingreso = $validatedData['motivo_ingreso'];
        $ingreso->save();

        // Actualizar estado de la habitación
        $habitacion->estado_habitacion = 'O'; // O = Ocupada
        $habitacion->save();

        return redirect()->route('ingresos.index')
            ->with('success', 'Ingreso registrado exitosamente.');
    }

    /**
     * Muestra los detalles de un ingreso específico.
     */
    public function show($id)
    {
        $ingreso = Ingreso::where('id_ingreso', $id)
            ->where('estado_auditoria', '1')
            ->with(['paciente.usuario', 'habitacion'])
            ->firstOrFail();

        return view('ingresos.show', compact('ingreso'));
    }

    /**
     * Registra la salida de un paciente.
     */
    public function registrarSalida(Request $request, $id)
    {
        $ingreso = Ingreso::where('id_ingreso', $id)
            ->where('estado_auditoria', '1')
            ->whereNull('fecha_salida')
            ->firstOrFail();

        // Registrar fecha de salida
        $ingreso->fecha_salida = Carbon::now();
        $ingreso->save();

        // Liberar la habitación
        $habitacion = Habitacion::find($ingreso->id_habitacion);
        $habitacion->estado_habitacion = 'L'; // L = Libre (pendiente de limpieza)
        $habitacion->observacion = 'Pendiente de limpieza después de la salida del paciente.';
        $habitacion->save();

        return redirect()->route('ingresos.index')
            ->with('success', 'Salida registrada exitosamente.');
    }

    /**
     * Elimina un ingreso específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $ingreso = Ingreso::where('id_ingreso', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $ingreso->estado_auditoria = '0';
        $ingreso->save();

        // Si no tiene fecha de salida, liberar la habitación
        if (!$ingreso->fecha_salida) {
            $habitacion = Habitacion::find($ingreso->id_habitacion);
            $habitacion->estado_habitacion = 'D'; // D = Disponible
            $habitacion->save();
        }

        return redirect()->route('ingresos.index')
            ->with('success', 'Ingreso eliminado exitosamente.');
    }
}
