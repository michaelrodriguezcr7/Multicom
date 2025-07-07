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
    ];

    public function ingresos()
    {
        return $this->hasMany(IngresoInventario::class);
    }
}
