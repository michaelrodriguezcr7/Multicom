<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
    $productos = Producto::orderBy('nombre')->get();
    return view('inventario.productos', compact('productos'));
    }

    public function buscar($codigo)
    {
    $producto = Producto::where('codigo', $codigo)->first();

    if ($producto) {
        return response()->json([
            'nombre' => $producto->nombre,
            'categoria' => $producto->categoria,
            'proveedor' => $producto->proveedor_actual, // o proveedor_nombre
            'valor_unitario' => $producto->valor_unitario
        ]);
    }

    return response()->json(null);
    }
}
