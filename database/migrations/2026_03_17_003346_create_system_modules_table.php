<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_modules', function (Blueprint $table) {
            $table->id();
            $table->string('module_key', 50)->unique();
            $table->string('module_name', 100);
            $table->string('icon', 100)->default('fas fa-cube');
            $table->string('description', 255)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });

        // Seed default modules
        DB::table('system_modules')->insert([
            ['module_key' => 'clientes',     'module_name' => 'Clientes',     'icon' => 'fas fa-users',         'description' => 'Gestión de clientes y contactos',     'enabled' => true, 'created_at' => now(), 'updated_at' => now()],
            ['module_key' => 'productos',    'module_name' => 'Productos',    'icon' => 'fas fa-box',           'description' => 'Catálogo de productos e inventario',   'enabled' => true, 'created_at' => now(), 'updated_at' => now()],
            ['module_key' => 'ventas',       'module_name' => 'Ventas',       'icon' => 'fas fa-shopping-cart', 'description' => 'Gestión de ventas y facturación',      'enabled' => true, 'created_at' => now(), 'updated_at' => now()],
            ['module_key' => 'empleados',    'module_name' => 'Empleados',    'icon' => 'fas fa-user-tie',      'description' => 'Gestión de empleados y asesores',      'enabled' => true, 'created_at' => now(), 'updated_at' => now()],
            ['module_key' => 'proveedores',  'module_name' => 'Proveedores',  'icon' => 'fas fa-truck',         'description' => 'Gestión de proveedores',               'enabled' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_modules');
    }
};
