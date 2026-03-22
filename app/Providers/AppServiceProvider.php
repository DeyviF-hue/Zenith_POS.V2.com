<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\SystemModule;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Load dynamically from database if tables exist
            if (Schema::hasTable('system_modules')) {
                $modules = SystemModule::all();
                foreach ($modules as $module) {
                    config(["modulos.{$module->module_key}" => [
                        'habilitado'  => $module->enabled,
                        'nombre'      => $module->module_name,
                        'icono'       => $module->icon,
                        'descripcion' => $module->description,
                    ]]);
                }
            }

            if (Schema::hasTable('system_settings')) {
                $settings = SystemSetting::all();
                foreach ($settings as $setting) {
                    config(["zenith.{$setting->key}" => $setting->value]);
                }
            }
        } catch (\Exception $e) {
            // Se ignora la excepción porque durante el comando de compilación
            // (por ejemplo `php artisan package:discover` en Docker/Railway)
            // aún no hay conexión a base de datos.
        }
        
        if (app()->environment('production')) {
        URL::forceScheme('https');
        }
    }
}
