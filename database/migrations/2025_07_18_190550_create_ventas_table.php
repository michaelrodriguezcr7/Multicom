<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id(); // id de la venta
            $table->unsignedBigInteger('id_usu'); // ID del usuario que realizó la venta
            $table->decimal('total', 10, 2);
            $table->timestamp('fecha')->useCurrent();
            $table->timestamps();

            // Clave foránea hacia la tabla usuarios
            $table->foreign('id_usu')->references('id_usu')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
