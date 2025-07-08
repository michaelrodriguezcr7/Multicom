<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IngresoInventario;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'nombre',
        'categoria',
        'proveedor_actual',
        'valor_unitario',
        'cantidad_total',
        'porcentaje_ganancia',
        'valor_venta',
    ];

    public function ingresos()
    {
        return $this->hasMany(IngresoInventario::class);
    }

    // Aquí va el método para calcular automáticamente el valor_venta
    protected static function booted()
    {
        static::saving(function ($producto) {
            $producto->valor_venta = $producto->valor_unitario * (1 + $producto->porcentaje_ganancia / 100);
        });
    }
}
