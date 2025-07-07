<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\IngresoInventario;
use Illuminate\Support\Facades\DB;

class IngresoInventarioController extends Controller
{
    public function index()
    {
    $ingresos = \App\Models\IngresoInventario::with('producto')
        ->orderBy('created_at', 'desc')
        ->take(50)
        ->get();

    return view('inventario.ingreso', compact('ingresos'));
    }

    
    public function store(Request $request)
    {
        // Validación de datos recibidos
        $request->validate([
            'codigo' => 'required|string',
            'nombre' => 'required|string',
            'categoria' => 'required|string',
            'cantidad_ingresada' => 'required|integer|min:1',
            'valor_unitario' => 'required|numeric|min:0',
            'proveedor' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Buscar producto por código
            $producto = Producto::where('codigo', $request->codigo)->first();

            // Si no existe, se crea
            if (!$producto) {
                $producto = Producto::create([
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'categoria' => $request->categoria,
                    'proveedor_actual' => $request->proveedor,
                    'valor_unitario' => $request->valor_unitario,
                    'cantidad_total' => $request->cantidad_ingresada,
                ]);
            } else {
                // Si existe, se actualiza su stock y precio
                $producto->cantidad_total += $request->cantidad_ingresada;
                $producto->valor_unitario = $request->valor_unitario;
                $producto->proveedor_actual = $request->proveedor;
                $producto->save();
            }

            // Registrar ingreso
            IngresoInventario::create([
                'producto_id' => $producto->id,
                'cantidad_ingresada' => $request->cantidad_ingresada,
                'valor_unitario' => $request->valor_unitario,
                'proveedor' => $request->proveedor,
                'fecha_ingreso' => now(),
                'observaciones' => $request->observaciones,
            ]);

            DB::commit();

            return redirect()->route('productos.inventario')->with('mensaje', 'producto creado');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar ingreso: ' . $e->getMessage()], 500);
        }
    }
}
