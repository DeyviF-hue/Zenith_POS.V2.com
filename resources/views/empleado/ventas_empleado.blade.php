@extends('adminlte::page')

@section('title', 'Ventas por Empleado')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-chart-bar mr-2"></i>Reporte de Ventas por Empleado</h1>
        <div>
            <a href="/ventas" class="btn btn-secondary mr-2">
            <i class="fas fa-arrow-left mr-1"></i>Volver a Ventas
            </a>
            <a href="/dashboard" class="btn btn-info">
            <i class="fas fa-home mr-1"></i>Ir al Inicio
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Resumen General -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h3>{{ count($empleadosConVentas) }}</h3>
                    <h6>Empleados con Ventas</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-receipt fa-2x mb-2"></i>
                    <h3>{{ $totalVentasGeneral }}</h3>
                    <h6>Total de Ventas</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                    <h3>S/ {{ number_format($totalGeneral, 2) }}</h3>
                    <h6>Total General</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h3>S/ {{ number_format($totalVentasGeneral > 0 ? $totalGeneral / $totalVentasGeneral : 0, 2) }}</h3>
                    <h6>Promedio por Venta</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Empleados -->
    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title mb-0"><i class="fas fa-trophy mr-1"></i>Ranking de Vendedores</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%" class="text-center">Posición</th>
                            <th>Empleado</th>
                            <th width="12%" class="text-center">Ventas Realizadas</th>
                            <th width="12%" class="text-center">Productos Vendidos</th>
                            <th width="15%" class="text-center">Total en Ventas</th>
                            <th width="15%" class="text-center">Promedio por Venta</th>
                            <th width="10%" class="text-center">Participación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleadosConVentas as $index => $empleado)
                        @php
                            $porcentaje = $totalGeneral > 0 ? ($empleado['total_ventas'] / $totalGeneral) * 100 : 0;
                            
                            // Determinar color según posición
                            if ($index == 0) {
                                $badgeClass = 'badge-warning'; // Oro
                            } elseif ($index == 1) {
                                $badgeClass = 'badge-secondary'; // Plata
                            } elseif ($index == 2) {
                                $badgeClass = 'badge-danger'; // Bronce
                            } else {
                                $badgeClass = 'badge-info';
                            }
                        @endphp
                        <tr>
                            <td class="text-center">
                                @if($index < 3)
                                    <span class="badge {{ $badgeClass }} py-2 px-3" style="font-size: 1.1em;">
                                        {{ $index + 1 }}°
                                    </span>
                                @else
                                    <span class="badge badge-light py-2 px-3" style="font-size: 1.1em;">
                                        {{ $index + 1 }}°
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $empleado['empleado']->nombre }} {{ $empleado['empleado']->apellidos }}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-id-badge mr-1"></i>ID: {{ $empleado['idasesor'] }}
                                </small>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary" style="font-size: 1em;">
                                    {{ $empleado['cantidad_ventas'] }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info" style="font-size: 1em;">
                                    {{ $empleado['total_productos'] }}
                                </span>
                            </td>
                            <td class="text-center font-weight-bold text-success">
                                S/ {{ number_format($empleado['total_ventas'], 2) }}
                            </td>
                            <td class="text-center font-weight-bold text-warning">
                                S/ {{ number_format($empleado['promedio_venta'], 2) }}
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success" style="font-size: 1em;">
                                    {{ number_format($porcentaje, 1) }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @if(count($empleadosConVentas) > 0)
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="2" class="text-right">TOTALES:</th>
                            <th class="text-center">{{ $totalVentasGeneral }}</th>
                            <th class="text-center">{{ array_sum(array_column($empleadosConVentas, 'total_productos')) }}</th>
                            <th class="text-center text-success">S/ {{ number_format($totalGeneral, 2) }}</th>
                            <th class="text-center text-warning">
                                S/ {{ number_format($totalVentasGeneral > 0 ? $totalGeneral / $totalVentasGeneral : 0, 2) }}
                            </th>
                            <th class="text-center">100%</th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Gráfico de Participación -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h3 class="card-title mb-0"><i class="fas fa-chart-pie mr-1"></i>Distribución de Ventas por Empleado</h3>
        </div>
        <div class="card-body">
            @if(count($empleadosConVentas) > 0)
            <div class="row">
                @foreach($empleadosConVentas as $index => $empleado)
                @php
                    $porcentaje = $totalGeneral > 0 ? ($empleado['total_ventas'] / $totalGeneral) * 100 : 0;
                    $color = match($index) {
                        0 => 'bg-warning',
                        1 => 'bg-secondary', 
                        2 => 'bg-danger',
                        default => 'bg-info'
                    };
                @endphp
                <div class="col-md-6 mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="font-weight-bold">
                            @if($index < 3) 
                                <i class="fas fa-trophy mr-1"></i>
                            @endif
                            {{ $empleado['empleado']->nombre }}
                        </span>
                        <span class="font-weight-bold">{{ number_format($porcentaje, 1) }}%</span>
                    </div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar {{ $color }} font-weight-bold" 
                             role="progressbar" 
                             style="width: {{ $porcentaje }}%"
                             aria-valuenow="{{ $porcentaje }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            S/ {{ number_format($empleado['total_ventas'], 2) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay datos de ventas por empleado</h5>
                <p class="text-muted">Registra algunas ventas para ver el reporte</p>
            </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.35rem;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .progress {
            border-radius: 10px;
            overflow: visible;
        }
        .progress-bar {
            border-radius: 10px;
            font-weight: bold;
            overflow: visible;
        }
        .badge-warning {
            background: linear-gradient(45deg, #FFD700, #FFA500);
        }
        .badge-secondary {
            background: linear-gradient(45deg, #C0C0C0, #A0A0A0);
        }
        .badge-danger {
            background: linear-gradient(45deg, #CD7F32, #8B4513);
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Reporte de ventas por empleado cargado correctamente');
    </script>
@stop