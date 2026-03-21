<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            ['name' => 'developer', 'description' => 'Control total del sistema (desarrollo)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'description' => 'Administrador del negocio', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cashier', 'description' => 'Usuario de punto de venta (cajero)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'supervisor', 'description' => 'Supervisor de ventas y reportes', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
