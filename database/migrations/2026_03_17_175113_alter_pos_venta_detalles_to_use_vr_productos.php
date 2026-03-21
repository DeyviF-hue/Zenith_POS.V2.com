<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Delete all existing POS venta details and ventas to avoid FK errors (Since POS logic is new, this is safe to just truncate or we delete them explicitly since we are moving away from legacy products).
        DB::table('pos_venta_detalles')->delete();
        DB::table('pos_ventas')->delete();

        Schema::table('pos_venta_detalles', function (Blueprint $table) {
            // Drop old legacy FK
            $table->dropForeign(['producto_id']);
            $table->dropColumn('producto_id');

            // Add new VR inventory FK
            $table->foreignId('vr_producto_id')->constrained('vr_productos')->onDelete('restrict')->after('pos_venta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_venta_detalles', function (Blueprint $table) {
            $table->dropForeign(['vr_producto_id']);
            $table->dropColumn('vr_producto_id');

            $table->char('producto_id', 5)->collation('utf8mb4_general_ci');
            $table->foreign('producto_id')->references('idproducto')->on('productos')->onDelete('restrict');
        });
    }
};
