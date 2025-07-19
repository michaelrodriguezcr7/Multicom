<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCantidadDisponibleToIngresosInventarioTable extends Migration
{
    public function up()
    {
        Schema::table('ingresos_inventario', function (Blueprint $table) {
            // Agregamos el campo solo si no existe
            if (!Schema::hasColumn('ingresos_inventario', 'cantidad_disponible')) {
                $table->integer('cantidad_disponible')
                      ->default(0)
                      ->after('cantidad_ingresada'); // si MySQL soporta, PostgreSQL lo ignora
            }
        });
    }

    public function down()
    {
        Schema::table('ingresos_inventario', function (Blueprint $table) {
            if (Schema::hasColumn('ingresos_inventario', 'cantidad_disponible')) {
                $table->dropColumn('cantidad_disponible');
            }
        });
    }
}
