<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\IngresoInventario;
use App\Models\DetalleVenta;

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

    //metodo show
    public function show($id)
    {
        return response()->json(['message' => 'Método no implementado'], 501);
    }

    // Actualizar producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string',
            'nombre' => 'required|string',
            'categoria' => 'required|string',
            'proveedor_actual' => 'required|string',
            'valor_unitario' => 'required|numeric|min:0',
            'porcentaje_ganancia' => 'required|numeric|min:0|max:100',
        ]);

        // 🔁 Actualizar en la tabla productos
        $producto = Producto::findOrFail($id);
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->categoria = $request->categoria;
        $producto->proveedor_actual = $request->proveedor_actual;
        $producto->valor_unitario = $request->valor_unitario;
        $producto->porcentaje_ganancia = $request->porcentaje_ganancia;
        $producto->save();

        // 🔁 Actualizar el último ingreso en la tabla ingreso_inventario
        $ultimoIngreso = IngresoInventario::where('producto_id', $producto->id)
                            ->orderBy('created_at', 'desc')
                            ->first();

        if ($ultimoIngreso) {
            $ultimoIngreso->valor_unitario = $producto->valor_unitario;
            $ultimoIngreso->proveedor = $producto->proveedor_actual;
            $ultimoIngreso->porcentaje_ganancia = $producto->porcentaje_ganancia;

            // Calcular valor de venta
            $valorVenta = $producto->valor_unitario + ($producto->valor_unitario * $producto->porcentaje_ganancia / 100);
            $ultimoIngreso->valor_venta = $valorVenta;

            $ultimoIngreso->save();
        }

        return redirect()->route('productos.index')->with('mensaje', '✅ Producto actualizado correctamente.');
    }


    // Eliminar producto y sus ingresos
    public function destroy($id)
    {
        $producto = Producto::with('ingresos')->findOrFail($id);

        // Verificar si el producto tiene ventas registradas
        $ventasRelacionadas = DetalleVenta::where('producto_id', $producto->id)->exists();

        if ($ventasRelacionadas) {
            return redirect()->route('productos.index')
                ->with('error', '❌ No se puede eliminar el producto "' . $producto->nombre . '" porque ya tiene ventas registradas.');
        }

        $mensaje = '✅ Producto "' . $producto->nombre . '" eliminado.';

        if ($producto->ingresos->count() > 0) {
            $mensaje .= ' También se eliminaron ' . $producto->ingresos->count() . ' registros de inventario.';
        }

        $producto->delete(); // eliminación en cascada si está definida

        return redirect()->route('productos.index')->with('mensaje', $mensaje);
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
