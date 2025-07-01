<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usu';
    public $timestamps = true;

    protected $fillable = [
        'ced_usu',
        'nom_usu',
        'ape_usu',
        'tel_usu',
        'cor_usu',
        'cargo_usu',
        'contraseña'
    ];

    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}
