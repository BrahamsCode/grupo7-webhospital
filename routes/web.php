<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SeguroMedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HorarioDoctorController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\RecetaMedicaController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta principal - Página de inicio
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/doctor', function () {
    return view('doctor'); // Muestra la vista 'doctor.blade.php'
});

Route::get('/usuarios', [UsuarioController::class,'index'])->name('usuarios.index');

Route::get('/medicamentos', [MedicamentoController::class,'index'])->name('medicamentos.index');

Route::get('/especialidades', [EspecialidadController::class,'index'])->name('especialidades.index');

Route::get('/doctores', [UsuarioController::class, 'doctores'])->name('doctores.index');

Route::get('/seguros', [SeguroMedicoController::class, 'index'])->name('seguros.index');

// Rutas de autenticación para usuarios no autenticados
// Route::middleware('guest')->group(function () {
    // Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    // Route::post('login', [LoginController::class, 'login']);
    // Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('register', [RegisterController::class, 'register']);
    // Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    // Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    // Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    // Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
// });

// Ruta de logout - para usuarios autenticados
// Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard
// Route::middleware(['auth'])->group(function () {
//     // Dashboard general
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

//     // Dashboard específico para doctores
//     Route::get('/dashboard/doctor', [DashboardController::class, 'doctor'])
//         ->middleware('role:3') // Rol de doctor
//         ->name('dashboard.doctor');

//     // Dashboard específico para pacientes
//     Route::get('/dashboard/paciente', [DashboardController::class, 'paciente'])
//         ->middleware('role:2') // Rol de paciente
//         ->name('dashboard.paciente');
// });

// Rutas protegidas por autenticación
// Route::middleware(['auth'])->group(function () {

//     // Rutas para Roles
//     Route::resource('roles', RolController::class);

//     // Rutas para Especialidades
//     Route::resource('especialidades', EspecialidadController::class);

//     // Rutas para Usuarios
//     Route::resource('usuarios', UsuarioController::class);

//     // Rutas para Seguros Médicos
//     Route::resource('seguros-medicos', SeguroMedicoController::class);

//     // Rutas para Pacientes
//     Route::resource('pacientes', PacienteController::class);

//     // Rutas para Horarios de Doctores
//     Route::resource('horarios-doctores', HorarioDoctorController::class);
//     Route::get('/horarios-disponibles', [HorarioDoctorController::class, 'horariosDisponibles'])
//         ->name('horarios-doctores.disponibles');

//     // Rutas para Citas
//     Route::resource('citas', CitaController::class);
//     Route::post('/citas/{id}/completar-consulta', [CitaController::class, 'completarConsulta'])
//         ->name('citas.completar-consulta');

//     // Rutas para Recetas Médicas
//     Route::resource('recetas-medicas', RecetaMedicaController::class);
//     Route::get('/recetas-medicas/{id}/pdf', [RecetaMedicaController::class, 'generarPDF'])
//         ->name('recetas-medicas.pdf');

//     // Rutas para Medicamentos
//     Route::resource('medicamentos', MedicamentoController::class);
//     Route::post('/medicamentos/{id}/actualizar-stock', [MedicamentoController::class, 'actualizarStock'])
//         ->name('medicamentos.actualizar-stock');

//     // Rutas para Tratamientos
//     Route::resource('tratamientos', TratamientoController::class);

//     // Rutas para Historial Clínico
//     Route::get('/historial-clinico/{id_paciente}', [HistorialClinicoController::class, 'show'])
//         ->name('historial-clinico.show');
//     Route::get('/historial-clinico/{id_paciente}/create', [HistorialClinicoController::class, 'create'])
//         ->name('historial-clinico.create');
//     Route::post('/historial-clinico/{id_paciente}', [HistorialClinicoController::class, 'store'])
//         ->name('historial-clinico.store');
//     Route::get('/historial-clinico/edit/{id}', [HistorialClinicoController::class, 'edit'])
//         ->name('historial-clinico.edit');
//     Route::put('/historial-clinico/{id}', [HistorialClinicoController::class, 'update'])
//         ->name('historial-clinico.update');
//     Route::delete('/historial-clinico/{id}', [HistorialClinicoController::class, 'destroy'])
//         ->name('historial-clinico.destroy');

//     // Rutas para Habitaciones
//     Route::resource('habitaciones', HabitacionController::class);
//     Route::post('/habitaciones/{id}/cambiar-estado', [HabitacionController::class, 'cambiarEstado'])
//         ->name('habitaciones.cambiar-estado');

//     // Rutas para Ingresos
//     Route::resource('ingresos', IngresoController::class);
//     Route::post('/ingresos/{id}/registrar-salida', [IngresoController::class, 'registrarSalida'])
//         ->name('ingresos.registrar-salida');

//     // Rutas para Facturas
//     Route::resource('facturas', FacturaController::class);
//     Route::get('/facturas/{id}/pdf', [FacturaController::class, 'generarPDF'])
//         ->name('facturas.pdf');

//     // Rutas para Pagos
//     Route::resource('pagos', PagoController::class);
//     Route::post('/facturas/{id_factura}/registrar-pago', [PagoController::class, 'registrarPago'])
//         ->name('pagos.registrar');
//     Route::post('/pagos/{id}/anular', [PagoController::class, 'anular'])
//         ->name('pagos.anular');
// });

// // Rutas específicas para administradores
// Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
//     // Aquí puedes agregar rutas exclusivas para administradores
//     Route::get('/estadisticas', function () {
//         return view('admin.estadisticas');
//     })->name('admin.estadisticas');
// });

// // Rutas específicas para doctores
// Route::middleware(['auth', 'role:3'])->prefix('doctor')->group(function () {
//     // Rutas exclusivas para doctores
//     Route::get('/mis-citas', function () {
//         return view('doctor.mis_citas');
//     })->name('doctor.mis-citas');

//     Route::get('/mis-pacientes', function () {
//         return view('doctor.mis_pacientes');
//     })->name('doctor.mis-pacientes');
// });

// // Rutas específicas para pacientes
// Route::middleware(['auth', 'role:2'])->prefix('paciente')->group(function () {
//     // Rutas exclusivas para pacientes
//     Route::get('/mis-citas', function () {
//         return view('paciente.mis_citas');
//     })->name('paciente.mis-citas');

//     Route::get('/mis-recetas', function () {
//         return view('paciente.mis_recetas');
//     })->name('paciente.mis-recetas');

//     Route::get('/mis-facturas', function () {
//         return view('paciente.mis_facturas');
//     })->name('paciente.mis-facturas');
// });
