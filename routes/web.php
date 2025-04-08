<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MedicamentoController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/usuarios', [UsuarioController::class,'index'])->name('usuarios.index');
Route::get('/medicamentos', [MedicamentoController::class,'index'])->name('medicamentos.index');