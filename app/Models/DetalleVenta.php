<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Venta;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'lote',
    ];

    /**
     * Relación: Un detalle de venta pertenece a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Relación: Un detalle de venta pertenece a una venta.
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}
