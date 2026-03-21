<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Default theme settings
        DB::table('system_settings')->insert([
            ['key' => 'primary_color',  'value' => '#6C5CE7', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'sidebar_color',  'value' => '#2D2A3A', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'accent_color',   'value' => '#A29BFE', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'theme_mode',     'value' => 'light',   'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
