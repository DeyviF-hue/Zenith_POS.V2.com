<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Developer (All access)
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('developer')) {
                return true;
            }
        });

        // Configuración y Módulos
        Gate::define('config-system', function ($user) {
            return false; // Only developer has access via Gate::before
        });

        // Gestión de Usuarios y Empleados
        Gate::define('manage-users', function ($user) {
            return $user->hasRole('admin');
        });

        // Punto de Venta (POS) y Crear Ventas
        Gate::define('pos', function ($user) {
            return $user->hasAnyRole(['admin', 'cashier']);
        });

        // Reportes e Historial de Ventas
        Gate::define('reports', function ($user) {
            return $user->hasAnyRole(['admin', 'supervisor']);
        });

        // Inventario Avanzado (Proveedores)
        Gate::define('inventory', function ($user) {
            return $user->hasRole('admin');
        });

        // Productos y Clientes
        Gate::define('catalog', function ($user) {
            return $user->hasAnyRole(['admin', 'cashier', 'supervisor']);
        });
    }
}
