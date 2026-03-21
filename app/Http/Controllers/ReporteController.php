<?php

namespace App\Http\Controllers;

use App\Models\AsesorVenta;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function ventasPorEmpleado()
    {
        $asesores = AsesorVenta::with(['empleado', 'ventas.detalles.producto'])->get();

        $empleadosConVentas = [];
        $totalGeneral = 0;
        $totalVentasGeneral = 0;

        foreach ($asesores as $asesor) {
            $totalVentasEmpleado = 0;
            $totalProductosEmpleado = 0;
            $cantidadVentas = $asesor->ventas->count();

            foreach ($asesor->ventas as $venta) {
                foreach ($venta->detalles as $detalle) {
                    if ($detalle->producto) {
                        $totalVentasEmpleado += $detalle->cantidad * $detalle->producto->precio;
                        $totalProductosEmpleado += $detalle->cantidad;
                    }
                }
            }

            if ($asesor->empleado) {
                $empleadosConVentas[] = [
                    'idasesor' => $asesor->idasesor,
                    'empleado' => $asesor->empleado,
                    'total_ventas' => $totalVentasEmpleado,
                    'total_productos' => $totalProductosEmpleado,
                    'cantidad_ventas' => $cantidadVentas,
                    'promedio_venta' => $cantidadVentas > 0 ? $totalVentasEmpleado / $cantidadVentas : 0
                ];

                $totalGeneral += $totalVentasEmpleado;
                $totalVentasGeneral += $cantidadVentas;
            }
        }

        usort($empleadosConVentas, function($a, $b) {
            return $b['total_ventas'] <=> $a['total_ventas'];
        });

        return view('empleado.ventas_empleado', compact(
            'empleadosConVentas', 
            'totalGeneral', 
            'totalVentasGeneral'
        ));
    }
}