<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Ruta para procesar el login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');