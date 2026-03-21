<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        #===========================================
        #Creacion de la tabla pos_venta_detalles
        #===========================================
        Schema::create('pos_venta_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_venta_id')->constrained()->onDelete('cascade');
            $table->char('producto_id', 5)->collation('utf8mb4_general_ci');
            $table->foreign('producto_id')->references('idproducto')->on('productos')->onDelete('restrict');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_venta_detalles');
    }
};
