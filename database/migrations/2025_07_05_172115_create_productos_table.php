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
        Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique();          // Código único
        $table->string('nombre');                   // Nombre del producto
        $table->string('categoria');                // Categoría (ropa, etc.)
        $table->string('proveedor_actual');         // Último proveedor que lo surtió
        $table->decimal('valor_unitario', 10, 2)->default(0); // Precio actual
        $table->integer('cantidad_total')->default(0);        // Stock actual
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
