<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleVenta;
use App\Models\Usuario; // Asegúrate que exista este modelo y esté bien referenciado

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'fecha',
        'total',
        'id_usu', // Campo agregado
    ];

    // Relación con los detalles de venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    // Relación con el usuario que realizó la venta
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usu');
    }
}
