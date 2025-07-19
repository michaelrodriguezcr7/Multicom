<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CorreosController;
use App\Http\Controllers\IngresoInventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;

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

    // ingreso de productos, vista inventario
    Route::get('/ingreso-inventario', [IngresoInventarioController::class, 'index'])->name('ingreso.formulario');
    Route::post('/ingreso-inventario', [IngresoInventarioController::class, 'store'])->name('ingreso.guardar');

    
    //metodo resource remplaza todas las rutas
    Route::resource('productos', ProductoController::class);
    // busqueda de producto por codigo
    Route::get('/producto/buscar/{codigo}', [ProductoController::class, 'buscar'])->name('producto.buscar');



    //ventas
    Route::get('/ventas/registrar', [VentaController::class, 'create'])->name('ventas.create');
    //guardar venta
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    // buscar produto
    Route::get('/productosx/buscar', [VentaController::class, 'buscarv'])->name('productosv.buscar');




    //pendientes

    //vista de eliminar
    Route::get('/ventas/eliminar', [VentaController::class, 'index'])->name('ventas.eliminar');

    //metodo de eliminar
    Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');


});
