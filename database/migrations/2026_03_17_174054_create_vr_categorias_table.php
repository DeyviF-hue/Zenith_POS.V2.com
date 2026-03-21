<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vr_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60)->unique();
            $table->string('icono', 50)->default('fas fa-tag'); // FontAwesome icon
            $table->string('color', 20)->default('#6C5CE7');    // Color hex
            $table->timestamps();
        });

        // Seed default categories
        DB::table('vr_categorias')->insert([
            ['nombre' => 'Todos',      'icono' => 'fas fa-th-large', 'color' => '#6C5CE7', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Bebidas',    'icono' => 'fas fa-glass-whiskey', 'color' => '#0984e3', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Snacks',     'icono' => 'fas fa-cookie',   'color' => '#e17055', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Limpieza',   'icono' => 'fas fa-spray-can','color' => '#00b894', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Electrónica','icono' => 'fas fa-microchip','color' => '#fdcb6e', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('vr_categorias');
    }
};
