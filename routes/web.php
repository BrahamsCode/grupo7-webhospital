<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\SeguroMedicoController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/doctor', function () {
    return view('doctor'); // Muestra la vista 'doctor.blade.php'
}); 

Route::get('/usuarios', [UsuarioController::class,'index'])->name('usuarios.index');

Route::get('/medicamentos', [MedicamentoController::class,'index'])->name('medicamentos.index');

Route::get('/especialidades', [EspecialidadController::class,'index'])->name('especialidades.index');

Route::get('/doctores', [UsuarioController::class, 'doctores'])->name('doctores.index');

Route::get('/seguros', [SeguroMedicoController::class, 'index'])->name('seguros.index');
