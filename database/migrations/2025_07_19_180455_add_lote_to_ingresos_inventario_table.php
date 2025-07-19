<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('ingresos_inventario', function (Blueprint $table) {
            $table->string('lote')->nullable()->after('fecha_ingreso');
        });
    }

    public function down()
    {
        Schema::table('ingresos_inventario', function (Blueprint $table) {
            $table->dropColumn('lote');
        });
    }
};
