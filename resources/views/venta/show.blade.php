@extends('adminlte::page')

@section('title', 'Detalle de Venta')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-receipt mr-2"></i>Detalle de Venta #{{ $venta->idventa }}</h1>
        <a href="{{ route('venta.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Volver al Historial
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- Información de la venta -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title mb-0"><i class="fas fa-info-circle mr-1"></i>Información de la Venta</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Número de Venta:</strong><br>
                                <span class="badge badge-primary">#{{ $venta->idventa }}</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Fecha:</strong><br>
                                {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}
                            </div>
                            <div class="col-md-4">
                                <strong>Total:</strong><br>
                                <span class="font-weight-bold text-success">S/ {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Cliente:</strong><br>
                                {{ $venta->cliente->Nombre }} {{ $venta->cliente->Apellidos }}<br>
                                <small class="text-muted">CUIT: {{ $venta->cliente->CUIT }}</small>
                            </div>
                            <div class="col-md-6">
                                <strong>Asesor:</strong><br>
                                @if($venta->asesor && $venta->asesor->empleado)
                                    {{ $venta->asesor->empleado->nombre }} {{ $venta->asesor->empleado->apellidos }}<br>
                                    <small class="text-muted">Código: {{ $venta->asesor->idasesor }}</small>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalle de productos -->
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0"><i class="fas fa-boxes mr-1"></i>Productos Vendidos</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th width="15%">Precio Unit.</th>
                                        <th width="15%">Cantidad</th>
                                        <th width="15%">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->detalles as $detalle)
                                        <tr>
                                            <td>
                                                <strong>{{ $detalle->producto->descripcion }}</strong><br>
                                                <small class="text-muted">Código: {{ $detalle->producto->idproducto }}</small>
                                            </td>
                                            <td>S/ {{ number_format($detalle->producto->precio, 2) }}</td>
                                            <td>{{ $detalle->cantidad }}</td>
                                            <td class="font-weight-bold">
                                                S/ {{ number_format($detalle->cantidad * $detalle->producto->precio, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td colspan="3" class="text-right font-weight-bold">TOTAL:</td>
                                        <td class="font-weight-bold">S/ {{ number_format($total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Acciones -->
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="card-title mb-0"><i class="fas fa-cogs mr-1"></i>Acciones</h3>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('venta.index') }}" class="btn btn-secondary btn-block mb-2">
                            <i class="fas fa-list mr-1"></i>Volver al Historial
                        </a>
                        
                        @if($venta->detalles->count() > 0)
                            <form action="{{ route('venta.destroy', $venta->idventa) }}" method="post" class="d-inline-block w-100">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block" 
                                        onclick="return confirm('¿Está seguro de anular esta venta? Se restablecerá el stock de los productos.')">
                                    <i class="fas fa-ban mr-1"></i>Anular Venta
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Resumen -->
                <div class="card mt-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title mb-0"><i class="fas fa-chart-bar mr-1"></i>Resumen</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fas fa-box fa-2x text-primary mb-2"></i>
                                <h5>{{ $venta->detalles->count() }}</h5>
                                <small class="text-muted">Productos Vendidos</small>
                            </div>
                            <div class="mb-3">
                                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                                <h5>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</h5>
                                <small class="text-muted">Fecha de Venta</small>
                            </div>
                        </div>
                    </div>
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
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Detalle de venta cargado correctamente!");
    </script>
@stop