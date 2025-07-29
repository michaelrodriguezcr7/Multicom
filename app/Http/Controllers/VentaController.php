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

    public function index()
    {
        $productos = Producto::all();
        $ventas = Venta::with('usuario')->get();

        return response()
            ->view('ventas.ventas', compact('productos', 'ventas'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        try {

                // Validar si hay productos en el carrito
            $detalle = json_decode($request->detalleVenta, true);

            if (empty($detalle)) {
                return redirect()->route('ventas.create')
                    ->with('mensaje', '⚠️ No hay ningún producto seleccionado para procesar la venta.');
            }
            
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

                
                // 5. Descontar del inventario (FIFO)
                $ingresos = IngresoInventario::where('producto_id', $producto_id)
                    ->where('cantidad_disponible', '>', 0)
                    ->orderBy('fecha_ingreso')
                    ->get();

                foreach ($ingresos as $ingreso) {
                    if ($cantidad_a_vender <= 0) break;

                    // Calculamos cuánto se puede vender de este lote
                    $cantidad_a_vender_de_este_lote = min($ingreso->cantidad_disponible, $cantidad_a_vender);

                    // Actualizamos el inventario
                    $ingreso->cantidad_disponible -= $cantidad_a_vender_de_este_lote;
                    $ingreso->save();

                    // Restamos del total que queda por vender
                    $cantidad_a_vender -= $cantidad_a_vender_de_este_lote;

                    // Guardamos el detalle de la venta por lote
                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $producto_id,
                        'cantidad' => $cantidad_a_vender_de_este_lote,
                        'precio_unitario' => $precio_unitario,
                        'subtotal' => $precio_unitario * $cantidad_a_vender_de_este_lote,
                        'lote' => $ingreso->lote,
                    ]);
                }


                                // 6. Actualizar la cantidad total en la tabla productos
                $totalDisponible = IngresoInventario::where('producto_id', $producto_id)->sum('cantidad_disponible');

                Producto::where('id', $producto_id)->update([
                    'cantidad_total' => $totalDisponible,
                ]);

                // Validación: si no alcanzó el inventario
                if ($cantidad_a_vender > 0) {
                     $producto = Producto::find($producto_id);
                    DB::rollBack();
                    return redirect()->route('ventas.create')->with('mensaje', 'No hay más unidades disponibles del producto: ' . $producto->nombre);
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
            ->get()
            ->map(function ($producto) {
                // Buscar el primer ingreso con stock disponible (FIFO)
                $primerLote = $producto->ingresos()
                    ->where('cantidad_disponible', '>', 0)
                    ->orderBy('fecha_ingreso', 'asc')
                    ->first();

                // ✅ Reemplazamos valor_unitario por valor_venta
                $valorVenta = $primerLote ? $primerLote->valor_venta : 0;

                return [
                    'id' => $producto->id,
                    'codigo' => $producto->codigo,
                    'nombre' => $producto->nombre,
                    'valor_venta' => $valorVenta, // ahora es el precio de venta real del lote
                ];
            });

        if ($productos->isEmpty()) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($productos);
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $venta = Venta::with('detalles')->findOrFail($id);

            foreach ($venta->detalles as $detalle) {
                // Buscar el lote específico del que se descontó la cantidad
                $ingreso = IngresoInventario::where('producto_id', $detalle->producto_id)
                            ->where('lote', $detalle->lote)
                            ->first();

                if ($ingreso) {
                    // Devolver la cantidad al inventario
                    $ingreso->cantidad_disponible += $detalle->cantidad;
                    $ingreso->save();
                }

                // 🔄 Actualizar la cantidad_total en productos
                $cantidad_total = IngresoInventario::where('producto_id', $detalle->producto_id)->sum('cantidad_disponible');

                Producto::where('id', $detalle->producto_id)->update([
                    'cantidad_total' => $cantidad_total
                ]);
            }

            // Eliminar los detalles de la venta
            $venta->detalles()->delete();

            // Eliminar la venta
            $venta->delete();

            DB::commit();

            return redirect()->route('ventas.create')->with('mensaje', 'venta eliminada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }



}
