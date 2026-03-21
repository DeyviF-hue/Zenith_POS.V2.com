<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\VentasRapidasController;
use App\Http\Controllers\VrInventarioController;
use Illuminate\Support\Facades\Auth;




Auth::routes();
 //Rutas cliente y login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');
// Rutas de Clientes
Route::get('cliente', [ClienteController::class, 'index'])->name('cliente.index')->middleware(['auth', 'module:clientes', 'role:admin,cashier,supervisor']);
Route::get('cliente/{cliente}', [ClienteController::class, 'show'])->name('cliente.show')->middleware(['auth', 'module:clientes', 'role:admin,cashier,supervisor']);
Route::resource('cliente', ClienteController::class)->except(['index', 'show'])->middleware(['auth', 'module:clientes', 'role:admin']);
Route::post('/clientes', [ClienteController::class, 'store'])->name('cliente.store')->middleware(['auth', 'module:clientes', 'role:admin']);

// Rutas de Productos
Route::get('producto', [ProductoController::class, 'index'])->name('producto.index')->middleware(['auth', 'module:productos', 'role:admin,cashier,supervisor']);
Route::get('producto/{producto}', [ProductoController::class, 'show'])->name('producto.show')->middleware(['auth', 'module:productos', 'role:admin,cashier,supervisor']);
Route::resource('producto', ProductoController::class)->except(['index', 'show'])->middleware(['auth', 'module:productos', 'role:admin']);

// Rutas de Ventas
Route::get('venta/create', [VentaController::class, 'create'])->name('venta.create')->middleware(['auth', 'module:ventas', 'role:admin,cashier']);
Route::post('venta', [VentaController::class, 'store'])->name('venta.store')->middleware(['auth', 'module:ventas', 'role:admin,cashier']);
Route::resource('venta', VentaController::class)->except(['create', 'store'])->middleware(['auth', 'module:ventas', 'role:admin,supervisor']);
Route::get('/ventas/mes', [VentaController::class, 'ventasMes'])->name('venta.mes')->middleware(['auth', 'module:ventas', 'role:admin,supervisor']);
Route::get('/ventas/historial', [VentaController::class, 'historial'])->name('venta.historial')->middleware(['auth', 'module:ventas', 'role:admin,supervisor']);

// Ventas Rápidas POS (cajero, admin, supervisor, developer)
Route::middleware(['auth', 'role:cashier,admin,developer,supervisor'])->group(function () {
    Route::get('/ventas-rapidas/buscar-productos', [VentasRapidasController::class, 'buscarProductos'])
         ->name('ventas-rapidas.buscar');
    Route::resource('ventas-rapidas', VentasRapidasController::class)
         ->except(['edit', 'update', 'destroy']);
});

// Inventario VR - Administración (admin / developer)
Route::middleware(['auth', 'role:admin,developer'])->group(function () {
    // AJAX: lista de productos del inventario VR para el POS (acceso también para cajero)
    Route::get('/vr-inventario/buscar', [VrInventarioController::class, 'buscar'])
         ->name('vr-inventario.buscar')->withoutMiddleware(['role:admin,developer']);
    Route::middleware(['auth', 'role:cashier,admin,developer,supervisor'])->group(function() {
        Route::get('/vr-inventario/buscar', [VrInventarioController::class, 'buscar'])
             ->name('vr-inventario.buscar.pos');
    });
    Route::resource('vr-inventario', VrInventarioController::class);
});

// Rutas de Empleados
Route::get('/empleado/ventas-empleado', [ReporteController::class, 'ventasPorEmpleado'])
    ->name('empleado.ventas_empleado')->middleware(['auth', 'module:empleados', 'role:admin,supervisor']);
Route::resource('empleado', EmpleadoController::class)->middleware(['auth', 'module:empleados', 'role:admin']);

// Proveedores
Route::resource('proveedor', ProveedorController::class)->middleware(['auth', 'module:proveedores', 'role:admin']);

// Rutas de Configuración del Sistema
Route::middleware(['auth', 'role:developer'])->prefix('configuracion')->name('configuracion.')->group(function () {
    Route::get('/modulos',             [ConfiguracionController::class, 'modulos'])->name('modulos');
    Route::post('/modulos/toggle',     [ConfiguracionController::class, 'toggleModulo'])->name('modulos.toggle');
    Route::get('/sistema',             [ConfiguracionController::class, 'sistema'])->name('sistema');
    Route::get('/apariencia',          [ConfiguracionController::class, 'apariencia'])->name('apariencia');
    Route::post('/apariencia',         [ConfiguracionController::class, 'guardarApariencia'])->name('apariencia.guardar');
});

Route::middleware(['auth', 'role:admin'])->prefix('configuracion')->name('configuracion.')->group(function () {
    Route::get('/usuarios',            [ConfiguracionController::class, 'usuarios'])->name('usuarios'); // also matches developer because of CheckRole bypass
});

