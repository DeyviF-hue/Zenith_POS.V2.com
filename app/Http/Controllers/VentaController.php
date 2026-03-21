<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use App\Models\AsesorVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['cliente', 'asesor.empleado', 'detalles.producto'])->get();
        return view('venta.venta', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $asesores = AsesorVenta::with('empleado')->get();
        $productos = Producto::where('stock', '>', 0)->get();
        
        return view('venta.create', compact('clientes', 'asesores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'CUIT' => 'required|exists:clientes,CUIT',
            'idasesor' => 'required|exists:asesores_ventas,idasesor',
            'productos' => 'required|array|min:1',
            'productos.*.idproducto' => 'required|exists:productos,idproducto',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            // Crear la venta
            $venta = Venta::create([
                'fecha' => $request->fecha,
                'CUIT' => $request->CUIT,
                'idasesor' => $request->idasesor
            ]);

            // Procesar cada producto
            foreach ($request->productos as $productoVenta) {
                $producto = Producto::find($productoVenta['idproducto']);
                
                // Verificar stock disponible
                if ($producto->stock < $productoVenta['cantidad']) {
                    throw new \Exception("Stock insuficiente para: " . $producto->descripcion);
                }

                // Crear detalle de venta
                DetalleVenta::create([
                    'idventa' => $venta->idventa,
                    'idproducto' => $productoVenta['idproducto'],
                    'cantidad' => $productoVenta['cantidad']
                ]);

                // Reducir stock
                $producto->stock -= $productoVenta['cantidad'];
                $producto->save();
            }

            DB::commit();

            return redirect()->route('venta.index')
                ->with('success', 'Venta registrada exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al registrar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function show($id)
    {
        $venta = Venta::with(['cliente', 'asesor.empleado', 'detalles.producto'])->findOrFail($id);
        
        // Calcular total de la venta
        $total = 0;
        foreach ($venta->detalles as $detalle) {
            $total += $detalle->cantidad * $detalle->producto->precio;
        }
        
        return view('venta.show', compact('venta', 'total'));
    }

    public function edit($id)
    {
        // Por ahora no implementaremos edición de ventas
        return redirect()->route('venta.index')
            ->with('info', 'La edición de ventas no está disponible');
    }

    public function update(Request $request, $id)
    {
        // Por ahora no implementaremos edición de ventas
        return redirect()->route('venta.index')
            ->with('info', 'La edición de ventas no está disponible');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $venta = Venta::findOrFail($id);

            // Devolver stock de los productos
            foreach ($venta->detalles as $detalle) {
                $producto = Producto::find($detalle->idproducto);
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }

            // Eliminar detalles primero
            $venta->detalles()->delete();
            
            // Eliminar la venta
            $venta->delete();

            DB::commit();

            return redirect()->route('venta.index')
                ->with('success', 'Venta eliminada exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('venta.index')
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    public function ventasMes()
    {
        $mesActual = date('m');
        $anoActual = date('Y');

        // Obtener ventas del mes actual
        $ventas = Venta::with(['cliente', 'detalles.producto'])
                    ->whereMonth('fecha', $mesActual)
                    ->whereYear('fecha', $anoActual)
                    ->get();

        // Calcular estadísticas del mes
        $totalMes = 0;
        $totalProductos = 0;
        $ventasPorDia = [];

        foreach ($ventas as $venta) {
            foreach ($venta->detalles as $detalle) {
                $totalMes += $detalle->cantidad * $detalle->producto->precio;
                $totalProductos += $detalle->cantidad;
            }
            
            // Agrupar por día para estadísticas
            $fecha = $venta->fecha;
            if (!isset($ventasPorDia[$fecha])) {
                $ventasPorDia[$fecha] = 0;
            }
            foreach ($venta->detalles as $detalle) {
                $ventasPorDia[$fecha] += $detalle->cantidad * $detalle->producto->precio;
            }
        }

        // Asegurarse de que las variables existan incluso si no hay ventas
        return view('venta.ventas_mes', compact('ventas', 'totalMes', 'totalProductos', 'ventasPorDia'));
    }

    public function historial()
    {
        // Obtener todas las ventas con sus relaciones necesarias, ordenadas por fecha descendente
        $ventas = Venta::with(['cliente', 'asesor.empleado', 'detalles.producto'])
                    ->orderBy('fecha', 'desc')
                    ->get();

        $totalVentas = $ventas->count();
        $totalGeneral = 0;
        $totalProductosVendidos = 0;

        foreach ($ventas as $venta) {
            foreach ($venta->detalles as $detalle) {
                $totalGeneral += $detalle->cantidad * $detalle->producto->precio;
                $totalProductosVendidos += $detalle->cantidad;
            }
        }

        return view('venta.historial', compact('ventas', 'totalVentas', 'totalGeneral', 'totalProductosVendidos'));
    }
}