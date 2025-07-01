<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CorreosController;

// Ruta de login (solo para invitados)
Route::middleware(['guest', 'throttle:10,1'])->group(function () {
    Route::get('/', [LoginController::class, 'formulario'])->name('login');         // Muestra el formulario
    Route::post('/verificar', [LoginController::class, 'verificar'])->name('verificar.usuario'); // Procesa login
    Route::post('/recuperar-password', [LoginController::class, 'restablecer'])->name('password.recuperar'); // Recupera clave
});

// Rutas protegidas (solo para usuarios autenticados)
Route::middleware('auth')->group(function () {

    // Página principal luego del login
    Route::get('/index', function () {
        return view('home.index');
    })->name('home');

    // CRUD de usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Eliminación múltiple de usuarios
    Route::delete('/usuarios-masivo', [UsuarioController::class, 'eliminarMultiples'])->name('usuarios.eliminar.multiples');

    // Envio de correos
    Route::post('/enviar-contacto', [CorreosController::class, 'enviarContacto'])->name('enviar.contacto');

    // Cerrar sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
