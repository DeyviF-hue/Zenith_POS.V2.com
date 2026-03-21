@extends('adminlte::page')

@section('title', 'Historial Completo de Ventas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-history mr-2"></i>Historial Completo de Ventas</h1>
        <div>
            <a href="{{ route('venta.index') }}" class="btn btn-secondary btn-sm mr-2">
                <i class="fas fa-arrow-left mr-1"></i>Volver al Historial
            </a>
            <a href="{{ route('venta.mes') }}" class="btn btn-info btn-sm">
                <i class="fas fa-chart-line mr-1"></i>Ver Ventas del Mes
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Resumen General -->
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-receipt fa-2x mb-2"></i>
                            <h3>{{ $totalVentas }}</h3>
                            <h6>Total de Ventas</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                            <h3>S/ {{ number_format($totalGeneral, 2) }}</h3>
                            <h6>Total General</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <h3>{{ $totalProductosVendidos }}</h3>
                            <h6>Productos Vendidos</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial Completo -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0"><i class="fas fa-list-alt mr-1"></i>Todas las Ventas Registradas</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="8%"># Venta</th>
                                <th width="12%">Fecha</th>
                                <th>Cliente</th>
                                <th>Asesor</th>
                                <th width="10%">Productos</th>
                                <th width="12%">Total</th>
                                <th width="15%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ventas as $venta)
                                @php
                                    $totalVenta = 0;
                                    foreach ($venta->detalles as $detalle) {
                                        $totalVenta += $detalle->cantidad * $detalle->producto->precio;
                                    }
                                @endphp
                                <tr>
                                    <td class="font-weight-bold text-primary">#{{ $venta->idventa }}</td>
                                    <td>
                                        <i class="fas fa-calendar text-muted mr-1"></i>
                                        {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <strong>{{ $venta->cliente->Nombre }} {{ $venta->cliente->Apellidos }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $venta->cliente->CUIT }}</small>
                                    </td>
                                    <td>
                                        @if($venta->asesor && $venta->asesor->empleado)
                                            {{ $venta->asesor->empleado->nombre }} {{ $venta->asesor->empleado->apellidos }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">{{ $venta->detalles->count() }}</span>
                                    </td>
                                    <td class="font-weight-bold text-success">
                                        S/ {{ number_format($totalVenta, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('venta.show', $venta->idventa) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="Ver detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('venta.destroy', $venta->idventa) }}" 
                                                  method="post" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de anular esta venta? Se restablecerá el stock de los productos.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Anular">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No hay ventas registradas</h5>
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
            @if($ventas->count())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Mostrando <strong>{{ $ventas->count() }}</strong> venta(s) en total
                        </small>
                        <small class="text-muted font-weight-bold">
                            Total General: S/ {{ number_format($totalGeneral, 2) }}
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .btn-group .btn {
            margin: 0 2px;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.35rem;
        }
    </style>
@stop