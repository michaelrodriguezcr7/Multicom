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
      
    }

    public function store(Request $request)
    {
        // ✅ Validación de los campos
        $request->validate([
            'codigo' => 'required|string',
            'nombre' => 'required|string',
            'categoria' => 'required|string',
            'cantidad_ingresada' => 'required|integer|min:1',
            'valor_unitario' => 'required|numeric|min:0',
            'porcentaje_ganancia' => 'required|numeric|min:0',
            'proveedor' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // 🔍 Buscar producto por código
            $producto = Producto::where('codigo', $request->codigo)->first();

            if (!$producto) {
                // ➕ Crear nuevo producto
                $producto = Producto::create([
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'categoria' => $request->categoria,
                    'proveedor_actual' => $request->proveedor,
                    'valor_unitario' => $request->valor_unitario,
                    'cantidad_total' => $request->cantidad_ingresada,
                    'porcentaje_ganancia' => $request->porcentaje_ganancia,
                    // ⚠️ valor_venta se calculará automáticamente en el modelo
                ]);
            } else {
                // 🔁 Actualizar producto existente
                $producto->cantidad_total += $request->cantidad_ingresada;
                $producto->valor_unitario = $request->valor_unitario;
                $producto->porcentaje_ganancia = $request->porcentaje_ganancia;
                $producto->proveedor_actual = $request->proveedor;
                $producto->save();
            }

            // 📝 Generar el lote automáticamente
            $ultimoId = IngresoInventario::max('id') ?? 0;
            $lote = 'Lote-' . str_pad($ultimoId + 1, 4, '0', STR_PAD_LEFT);
            
            // 📝 Registrar ingreso en el inventario
            IngresoInventario::create([
                'producto_id' => $producto->id,
                'cantidad_ingresada' => $request->cantidad_ingresada,
                'cantidad_disponible' => $request->cantidad_ingresada,
                'valor_unitario' => $request->valor_unitario,
                'porcentaje_ganancia' => $request->porcentaje_ganancia,
                'valor_venta' => $request->valor_unitario + ($request->valor_unitario * $request->porcentaje_ganancia / 100),
                'proveedor' => $request->proveedor,
                'fecha_ingreso' => now(),
                'observaciones' => $request->observaciones,
                'lote' => $lote,
            ]);

            DB::commit();

            return redirect()->route('productos.index')->with('mensaje', 'Producto ingresado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar ingreso: ' . $e->getMessage());
        }
    }
}
