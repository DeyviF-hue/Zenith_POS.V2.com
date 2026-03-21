@extends('adminlte::page')

@section('title', 'Historial de Ventas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-shopping-cart mr-2"></i>Historial de Ventas</h1>
        <a href="{{ route('venta.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle mr-1"></i>Nueva Venta
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0"><i class="fas fa-list mr-1"></i>Lista de Ventas Registradas</h3>
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
                                    // Calcular total de la venta
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
                                        <span class="badge" style="background:#6C5CE7;color:#fff;border-radius:20px;padding:4px 10px;">{{ $venta->detalles->count() }} ítem(s)</span>
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
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta venta? Se restablecerá el stock de los productos.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
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
                            Mostrando <strong>{{ $ventas->count() }}</strong> venta(s)
                        </small>
                        <!-- Aquí puedes agregar paginación si la necesitas -->
                        {{-- {{ $ventas->links() }} --}}
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop


