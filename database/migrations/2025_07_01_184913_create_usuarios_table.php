<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id_usu');
            $table->bigInteger('ced_usu');
            $table->string('nom_usu', 45);
            $table->string('ape_usu', 45);
            $table->string('tel_usu', 45);
            $table->string('cor_usu', 45);
            $table->string('cargo_usu', 45);
            $table->string('contraseña', 255); // Largo suficiente para hashes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
