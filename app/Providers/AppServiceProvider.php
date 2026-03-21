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
        // Load dynamically from database if tables exist
        if (Schema::hasTable('system_modules')) {
            try {
                $modules = SystemModule::all();
                foreach ($modules as $module) {
                    config(["modulos.{$module->module_key}" => [
                        'habilitado'  => $module->enabled,
                        'nombre'      => $module->module_name,
                        'icono'       => $module->icon,
                        'descripcion' => $module->description,
                    ]]);
                }
            } catch (\Exception $e) {
                // Ignore exception if running without DB connection
            }
        }

        if (Schema::hasTable('system_settings')) {
            try {
                $settings = SystemSetting::all();
                foreach ($settings as $setting) {
                    config(["zenith.{$setting->key}" => $setting->value]);
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }
        
        if (app()->environment('production')) {
        URL::forceScheme('https');
        }
    }
}
