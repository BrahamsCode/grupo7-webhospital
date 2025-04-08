

<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Usuario;
use App\Models\Factura;
use App\Models\Medicamento;
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal del sistema.
     */
    public function index()
    {
        // Contadores básicos
        $pacientesCount = Paciente::where('estado_auditoria', '1')->count();
        $doctoresCount = Usuario::where('estado_auditoria', '1')->where('id_rol', 3)->count();
        $citasHoyCount = Cita::where('estado_auditoria', '1')
            ->whereDate('fecha_cita', Carbon::today())
            ->count();
        $habitacionesDisponiblesCount = Habitacion::where('estado_auditoria', '1')
            ->where('estado_habitacion', 'D')
            ->count();

        // Estadísticas de facturación
        $facturacionMensual = Factura::where('estado_auditoria', '1')
            ->whereYear('fecha_emision', Carbon::now()->year)
            ->whereMonth('fecha_emision', Carbon::now()->month)
            ->sum('monto_total');

        $facturacionPorMes = Factura::where('estado_auditoria', '1')
            ->whereYear('fecha_emision', Carbon::now()->year)
            ->select(DB::raw('MONTH(fecha_emision) as mes'), DB::raw('SUM(monto_total) as total'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Próximas citas
        $proximasCitas = Cita::where('estado_auditoria', '1')
            ->where('estado', 'P') // Pendientes
            ->whereDate('fecha_cita', '>=', Carbon::today())
            ->with(['paciente.usuario', 'doctor'])
            ->orderBy('fecha_cita')
            ->limit(5)
            ->get();

        // Medicamentos con bajo stock
        $medicamentosBajoStock = Medicamento::where('estado_auditoria', '1')
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        // Especialidades más solicitadas
        $especialidadesSolicitadas = Cita::where('citas.estado_auditoria', '1')
            ->join('usuarios', 'citas.id_usuario_doctor', '=', 'usuarios.id_usuario')
            ->join('especialidades', 'usuarios.id_especialidad', '=', 'especialidades.id_especialidad')
            ->select('especialidades.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('especialidades.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'pacientesCount',
            'doctoresCount',
            'citasHoyCount',
            'habitacionesDisponiblesCount',
            'facturacionMensual',
            'facturacionPorMes',
            'proximasCitas',
            'medicamentosBajoStock',
            'especialidadesSolicitadas'
        ));
    }

    /**
     * Muestra el dashboard específico para doctores.
     */
    public function doctor()
    {
        $idDoctor = auth()->user()->id_usuario;

        // Próximas citas del doctor
        $proximasCitas = Cita::where('estado_auditoria', '1')
            ->where('id_usuario_doctor', $idDoctor)
            ->where('estado', 'P') // Pendientes
            ->whereDate('fecha_cita', '>=', Carbon::today())
            ->with('paciente.usuario')
            ->orderBy('fecha_cita')
            ->limit(10)
            ->get();

        // Citas para hoy
        $citasHoy = Cita::where('estado_auditoria', '1')
            ->where('id_usuario_doctor', $idDoctor)
            ->whereDate('fecha_cita', Carbon::today())
            ->with('paciente.usuario')
            ->orderBy('fecha_cita')
            ->get();

        // Pacientes atendidos recientemente
        $pacientesRecientes = Cita::where('citas.estado_auditoria', '1')
            ->where('id_usuario_doctor', $idDoctor)
            ->where('estado', 'C') // Completadas
            ->with('paciente.usuario')
            ->orderByDesc('fecha_cita')
            ->limit(5)
            ->get();

        // Estadísticas de citas
        $citasPorMes = Cita::where('estado_auditoria', '1')
            ->where('id_usuario_doctor', $idDoctor)
            ->whereYear('fecha_cita', Carbon::now()->year)
            ->select(DB::raw('MONTH(fecha_cita) as mes'), DB::raw('COUNT(*) as total'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('dashboard.doctor', compact(
            'proximasCitas',
            'citasHoy',
            'pacientesRecientes',
            'citasPorMes'
        ));
    }

    /**
     * Muestra el dashboard específico para pacientes.
     */
    public function paciente()
    {
        $idUsuario = auth()->user()->id_usuario;
        $paciente = Paciente::where('id_usuario', $idUsuario)->first();

        if (!$paciente) {
            return redirect()->route('dashboard.index')
                ->with('error', 'No se encontró un perfil de paciente asociado a este usuario.');
        }

        // Próximas citas del paciente
        $proximasCitas = Cita::where('estado_auditoria', '1')
            ->where('id_paciente', $paciente->id_paciente)
            ->where('estado', 'P') // Pendientes
            ->whereDate('fecha_cita', '>=', Carbon::today())
            ->with('doctor')
            ->orderBy('fecha_cita')
            ->get();

        // Historial de citas
        $historialCitas = Cita::where('estado_auditoria', '1')
            ->where('id_paciente', $paciente->id_paciente)
            ->where('estado', 'C') // Completadas
            ->with('doctor')
            ->orderByDesc('fecha_cita')
            ->limit(5)
            ->get();

        // Recetas activas
        $recetasActivas = Cita::where('citas.estado_auditoria', '1')
            ->where('id_paciente', $paciente->id_paciente)
            ->whereHas('recetasMedicas', function ($query) {
                $query->where('estado', 'A'); // Activas
            })
            ->with(['recetasMedicas.detallesReceta.medicamento', 'doctor'])
            ->orderByDesc('fecha_cita')
            ->limit(3)
            ->get();

        // Facturas pendientes
        $facturasPendientes = Factura::where('estado_auditoria', '1')
            ->where('id_paciente', $paciente->id_paciente)
            ->where('estado', 'P') // Pendientes
            ->with('detallesFactura')
            ->orderByDesc('fecha_emision')
            ->get();

        return view('dashboard.paciente', compact(
            'paciente',
            'proximasCitas',
            'historialCitas',
            'recetasActivas',
            'facturasPendientes'
        ));
    }
}
