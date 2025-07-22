<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class IngresoInventario extends Model
{
    protected $table = 'ingresos_inventario';

    protected $fillable = [
        'producto_id',
        'cantidad_ingresada',
        'cantidad_disponible',
        'valor_unitario',
        'porcentaje_ganancia',
        'valor_venta',
        'proveedor',
        'fecha_ingreso',
        'observaciones',
        'lote',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
