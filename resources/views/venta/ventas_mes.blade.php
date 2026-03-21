@extends('adminlte::page')

@section('title', 'Ventas del Mes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-chart-line mr-2"></i>Reporte de Ventas - {{ date('F Y') }}</h1>
        <div>
            <a href="{{ route('venta.index') }}" class="btn btn-secondary btn-sm mr-2">
                <i class="fas fa-arrow-left mr-1"></i>Volver los detalles
            </a>
            <a href="{{ route('venta.historial') }}" class="btn btn-info btn-sm">
                <i class="fas fa-history mr-1"></i>Ver Historial Completo
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <h3>{{ $ventas->count() ?? 0 }}</h3>
                            <h6>Ventas del Mes</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                            <h3>S/ {{ number_format($totalMes ?? 0, 2) }}</h3>
                            <h6>Total Vendido</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-boxes fa-2x mb-2"></i>
                            <h3>{{ $totalProductos ?? 0 }}</h3>
                            <h6>Productos Vendidos</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-calendar fa-2x mb-2"></i>
                            <h3>{{ count($ventasPorDia ?? []) }}</h3>
                            <h6>Días con Ventas</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico simple de ventas por día -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0"><i class="fas fa-chart-bar mr-1"></i>Ventas por Día - {{ date('F Y') }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Total Vendido</th>
                                <th width="20%">Barra de Progreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $ventasPorDia = $ventasPorDia ?? [];
                                $maxVenta = !empty($ventasPorDia) ? max($ventasPorDia) : 1;
                            @endphp
                            @if(!empty($ventasPorDia))
                                @foreach($ventasPorDia as $fecha => $totalDia)
                                    @php
                                        $porcentaje = ($totalDia / $maxVenta) * 100;
                                    @endphp
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</td>
                                        <td class="font-weight-bold text-success">S/ {{ number_format($totalDia, 2) }}</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: {{ $porcentaje }}%;" 
                                                     aria-valuenow="{{ $porcentaje }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ number_format($porcentaje, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">
                                        No hay ventas registradas este mes
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Lista detallada de ventas del mes -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0"><i class="fas fa-list mr-1"></i>Detalle de Ventas del Mes</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="8%"># Venta</th>
                                <th width="12%">Fecha</th>
                                <th>Cliente</th>
                                <th width="10%">Productos</th>
                                <th width="12%">Total</th>
                                <th width="10%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $ventas = $ventas ?? collect();
                            @endphp
                            @forelse ($ventas as $venta)
                                @php
                                    $totalVenta = 0;
                                    foreach ($venta->detalles as $detalle) {
                                        $totalVenta += $detalle->cantidad * $detalle->producto->precio;
                                    }
                                @endphp
                                <tr>
                                    <td class="font-weight-bold text-primary">#{{ $venta->idventa }}</td>
                                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $venta->cliente->Nombre }} {{ $venta->cliente->Apellidos }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $venta->cliente->CUIT }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">{{ $venta->detalles->count() }}</span>
                                    </td>
                                    <td class="font-weight-bold text-success">
                                        S/ {{ number_format($totalVenta, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('venta.show', $venta->idventa) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No hay ventas registradas este mes</h5>
                                        <a href="{{ route('venta.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus mr-1"></i>Registrar Primera Venta
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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
        }
    </style>
@stop