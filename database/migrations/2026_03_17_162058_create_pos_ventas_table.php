<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       #===========================================
       #Creacion de la tabla pos_ventas
       #===========================================
        Schema::create('pos_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('cliente_cuit', 15)->collation('utf8mb4_general_ci')->nullable();
            $table->foreign('cliente_cuit')->references('CUIT')->on('clientes')->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('igv', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('metodo_pago', ['efectivo', 'yape', 'plin', 'qr']);
            $table->enum('estado_pago', ['pagado', 'pendiente'])->default('pagado');
            $table->enum('comprobante', ['boleta', 'factura']);
            $table->dateTime('fecha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_ventas');
    }
};