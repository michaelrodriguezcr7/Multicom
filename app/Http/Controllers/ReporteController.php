<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    //
    public function estadisticasGenerales()
    {
        // Producto más vendido (general)
        $productoMasVendido = DB::table('detalle_ventas as dv')
            ->join('productos as p', 'dv.producto_id', '=', 'p.id')
            ->select('p.nombre', DB::raw('SUM(dv.cantidad) as total_vendido'))
            ->groupBy('p.id', 'p.nombre')
            ->orderByDesc('total_vendido')
            ->first();

        // Producto menos vendido (general)
        $productoMenosVendido = DB::table('detalle_ventas as dv')
            ->join('productos as p', 'dv.producto_id', '=', 'p.id')
            ->select('p.nombre', DB::raw('SUM(dv.cantidad) as total_vendido'))
            ->groupBy('p.id', 'p.nombre')
            ->orderBy('total_vendido', 'asc')
            ->first();

        // Número total de ventas
        $numeroVentas = DB::table('ventas')->count();

        // Vendedor con más ventas (por número de ventas)
        $vendedorTop = DB::table('ventas as v')
            ->join('usuarios as u', 'v.id_usu', '=', 'u.id_usu')
            ->select(DB::raw('CONCAT(u.nom_usu, " ", u.ape_usu) as nombre'), DB::raw('COUNT(v.id) as total_ventas'))
            ->groupBy('u.id_usu', 'u.nom_usu', 'u.ape_usu')
            ->orderByDesc('total_ventas')
            ->first();

        return view('reportes.ventas_diarias', compact(
            'productoMasVendido',
            'productoMenosVendido',
            'numeroVentas',
            'vendedorTop'
        ));
    }

   public function generarPDF()
    {
        $detalles = DB::table('ventas as v')
            ->join('detalle_ventas as dv', 'v.id', '=', 'dv.venta_id')
            ->join('productos as p', 'dv.producto_id', '=', 'p.id')
            ->join('usuarios as u', 'v.id_usu', '=', 'u.id_usu')
            ->leftJoin('ingresos_inventario as ii', function ($join) {
                $join->on('ii.producto_id', '=', 'dv.producto_id')
                    ->on('ii.lote', '=', 'dv.lote');
            })
            ->selectRaw('
                v.id as venta_id,
                DATE(v.fecha) as fecha,
                CONCAT(u.nom_usu, " ", u.ape_usu) as usuario,
                p.nombre as producto,
                dv.cantidad,
                dv.precio_unitario,
                (dv.cantidad * dv.precio_unitario) as total,
                ii.valor_unitario as costo_unitario,
                ((dv.precio_unitario - COALESCE(ii.valor_unitario, 0)) * dv.cantidad) as ganancia
            ')
            ->whereDate('v.fecha', today())
            ->orderBy('v.fecha', 'desc')
            ->get()
            ->groupBy('venta_id');

        $pdf = Pdf::loadView('reportes.ventas_pdf', compact('detalles'));
        return $pdf->stream('reporte_ventas.pdf');
    }




}
