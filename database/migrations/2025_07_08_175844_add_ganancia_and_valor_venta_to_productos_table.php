<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('porcentaje_ganancia', 5, 2)->default(0);
            $table->decimal('valor_venta', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['porcentaje_ganancia', 'valor_venta']);
        });
    }
};
