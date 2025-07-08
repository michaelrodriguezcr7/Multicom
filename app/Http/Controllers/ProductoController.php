<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Muestra la vista principal con todos los productos del inventario.
     */
    public function index()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('inventario.productos', compact('productos'));
    }

    /**
     * Busca un producto por su código y devuelve sus datos en JSON.
     */
    public function buscar($codigo)
    {
        $producto = Producto::where('codigo', $codigo)->first();

        if ($producto) {
            return response()->json([
                'nombre' => $producto->nombre,
                'categoria' => $producto->categoria,
                'proveedor' => $producto->proveedor_actual,
                'valor_unitario' => $producto->valor_unitario,
                'porcentaje_ganancia' => $producto->porcentaje_ganancia,
            ]);
        }

        return response()->json(null);
    }
}
