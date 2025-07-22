<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ingresos_inventario', function (Blueprint $table) {
        $table->decimal('porcentaje_ganancia', 5, 2)->default(0)->after('valor_unitario');
        $table->decimal('valor_venta', 10, 2)->default(0)->after('porcentaje_ganancia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresos_inventario', function (Blueprint $table) {
        $table->dropColumn(['porcentaje_ganancia', 'valor_venta']);
        });
    }
};
