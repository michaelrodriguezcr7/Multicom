<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->id('id_abono');
            $table->integer('valor_abono');
            $table->string('cedu_cli', 100);
            $table->string('nom_cli', 100)->nullable();
            $table->string('num_fac', 100)->nullable();
            $table->string('nom_vend', 150)->nullable();
            $table->unsignedInteger('id_venta')->nullable();
            $table->date('fecha')->nullable();
            $table->timestamps();
        });

        Schema::create('categoria', function (Blueprint $table) {
            $table->id('id_cat');
            $table->string('nom_cat', 100)->unique();
            $table->timestamps();
        });

        Schema::create('datos', function (Blueprint $table) {
            $table->id('id_dat');
            $table->string('nit', 100);
            $table->string('nom', 255);
            $table->string('tel', 100)->nullable();
            $table->string('dir', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('detalleventas', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedInteger('id_venta')->nullable();
            $table->string('id_producto', 100)->nullable();
            $table->string('nombre_articulo', 255);
            $table->integer('cantidad')->nullable();
            $table->integer('valor');
            $table->integer('valor_abonado');
            $table->integer('precio_restante');
            $table->timestamps();
        });

        Schema::create('fecha_producto', function (Blueprint $table) {
            $table->id('id_fec');
            $table->unsignedInteger('id_inv');
            $table->date('fecha');
            $table->timestamps();
        });

        Schema::create('gastos', function (Blueprint $table) {
            $table->id('id_gasto');
            $table->string('detalle', 255);
            $table->double('valor');
            $table->date('fecha');
            $table->unsignedInteger('id_usu');
            $table->timestamps();
        });

        Schema::create('producto', function (Blueprint $table) {
            $table->id('id_inv'); // equivale a: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('codigo', 100)->nullable();
            $table->string('nom_pro', 255);
            $table->double('pre_compra');
            $table->double('pre_venta');
            $table->integer('cantidad')->default(0);
            $table->integer('cantidad_min')->default(0);
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->timestamps();
        });

        Schema::create('provedores', function (Blueprint $table) {
            $table->id('id_pro');
            $table->string('nom_pro', 100);
            $table->string('nit_pro', 100);
            $table->string('tel_pro', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('renovacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nit', 50);
            $table->date('fecha_final_de_renovacion');
            $table->string('codigo_anual', 50)->nullable();
            $table->string('ubicacion');
            $table->timestamps();
        });

        Schema::create('separados', function (Blueprint $table) {
            $table->id('id_separado');
            $table->string('producto_id', 100)->nullable();
            $table->string('nombre_articulo', 255);
            $table->integer('cantidad')->nullable();
            $table->integer('valor');
            $table->integer('valor_abonado');
            $table->integer('precio_restante');
            $table->unsignedInteger('id_usu');
            $table->string('cedu_cli', 20);
            $table->string('nom_cli', 100)->nullable();
            $table->string('num_fac', 100)->nullable();
            $table->string('nom_vend', 150)->nullable();
            $table->unsignedInteger('id_venta')->nullable();
            $table->double('pre_cos')->nullable();
            $table->double('precioVenta')->nullable();
            $table->double('descuento')->nullable();
            $table->double('subtotal')->nullable();
            $table->string('tel_cli', 45)->nullable();
            $table->string('fec_enc', 30)->nullable();
            $table->unsignedInteger('id_inv')->nullable();
            $table->timestamps();
        });

        Schema::create('subunidad_producto', function (Blueprint $table) {
            $table->id('id_sub_pro');
            $table->string('cod_sub_nom', 255)->nullable();
            $table->string('nom_sub_pro', 100)->unique();
            $table->integer('can_sub_pro');
            $table->integer('res_sub_pro');
            $table->unsignedBigInteger('id_inv');
            $table->timestamps();

            $table->foreign('id_inv')->references('id_inv')->on('producto')->onUpdate('cascade');
        });

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usu'); // BIGINT UNSIGNED
            $table->bigInteger('ced_usu');
            $table->string('nom_usu', 45);
            $table->string('ape_usu', 45);
            $table->string('tel_usu', 45);
            $table->string('cor_usu', 45);
            $table->string('cargo_usu', 45);
            $table->string('contraseña', 45);
            $table->timestamps();
        });

        Schema::create('ventas', function (Blueprint $table) {
            $table->id('id_venta');
            $table->dateTime('fecha');
            $table->double('total');
            $table->string('num_fac', 100)->nullable();
            $table->string('nom_vend', 150)->nullable();
            $table->string('nom_cli', 100)->nullable();
            $table->string('dir_cli', 100)->nullable();
            $table->string('cel_cli', 45)->nullable();
            $table->string('cedu_cli', 100)->nullable();
            $table->string('tip_vent', 45)->nullable();
            $table->string('estado', 45)->default('Entregado');
            $table->date('fec_fin')->nullable();
            $table->unsignedBigInteger('id_usu'); // CAMBIO HECHO AQUÍ
            $table->dateTime('fec_final_pago')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('id_usu')->references('id_usu')->on('usuarios')->onUpdate('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('subunidad_producto');
        Schema::dropIfExists('separados');
        Schema::dropIfExists('renovacion');
        Schema::dropIfExists('provedores');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('gastos');
        Schema::dropIfExists('fecha_producto');
        Schema::dropIfExists('detalleventas');
        Schema::dropIfExists('datos');
        Schema::dropIfExists('categoria');
        Schema::dropIfExists('abonos');
    }
};
