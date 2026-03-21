<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vr_productos', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 30)->unique();
            $table->string('nombre', 120);
            $table->text('descripcion')->nullable();
            $table->foreignId('vr_categoria_id')->constrained('vr_categorias')->onDelete('restrict');
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(5);  // Alert threshold
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vr_productos');
    }
};
