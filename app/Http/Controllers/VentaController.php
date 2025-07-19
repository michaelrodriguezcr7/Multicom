<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\IngresoInventario;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function create()
    {
        $productos = Producto::all();
        return view('ventas.ventas', compact('productos'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // 1. Crear la venta
            $venta = Venta::create([
                'fecha' => now(),
                'total' => $request->total,
                'id_usu' => $request->id_usu,
            ]);

            // 2. Decodificar el detalle de la venta (JSON del carrito)
            $detalle = json_decode($request->detalleVenta, true);

            // 3. Iterar sobre los productos del carrito
            foreach ($detalle as $item) {
                $producto_id = $item['id'];
                $cantidad_a_vender = $item['cantidad'];
                $precio_unitario = $item['precio'];

                // 4. Guardar el detalle de la venta
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto_id,
                    'cantidad' => $cantidad_a_vender,
                    'precio_unitario' => $precio_unitario,
                    'subtotal' => $precio_unitario * $cantidad_a_vender,
                ]);

                // 5. Descontar del inventario (FIFO)
                $ingresos = IngresoInventario::where('producto_id', $producto_id)
                    ->where('cantidad_disponible', '>', 0)
                    ->orderBy('fecha_ingreso')
                    ->get();

                foreach ($ingresos as $ingreso) {
                    if ($cantidad_a_vender <= 0) break;

                    if ($ingreso->cantidad_disponible >= $cantidad_a_vender) {
                        $ingreso->cantidad_disponible -= $cantidad_a_vender;
                        $ingreso->save();
                        $cantidad_a_vender = 0;
                    } else {
                        $cantidad_a_vender -= $ingreso->cantidad_disponible;
                        $ingreso->cantidad_disponible = 0;
                        $ingreso->save();
                    }
                }

                // Validación: si no alcanzó el inventario
                if ($cantidad_a_vender > 0) {
                    DB::rollBack();
                    return response()->json([
                        'error' => 'Inventario insuficiente para el producto ID ' . $producto_id
                    ], 400);
                }
            }

            DB::commit();

            return redirect()->route('ventas.create')->with('mensaje', 'venta realizada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar la venta',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function buscarv(Request $request)
    {
        $query = $request->input('query');

        $productos = Producto::where('codigo', 'LIKE', "%{$query}%")
            ->orWhere('nombre', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        if ($productos->isEmpty()) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($productos);
    }



}
