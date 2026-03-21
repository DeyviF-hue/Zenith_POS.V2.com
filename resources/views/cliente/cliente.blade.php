@extends('adminlte::page')

@section('title', 'Gestión de Clientes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-users mr-2"></i>Gestión de Clientes</h1>
        <a href="{{ route('cliente.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle mr-1"></i>Nuevo Cliente
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0"><i class="fas fa-list mr-1"></i>Lista de Clientes</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">Código</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Ciudad</th>
                                <th>Telefono</th>
                                <th>Dirección</th>
                                <th width="12%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientes as $cliente)
                                <tr>
                                    <td class="font-weight-bold text-primary">{{ $cliente->CUIT }}</td>
                                    <td>{{ $cliente->Nombre }}</td>
                                    <td>{{ $cliente->Apellidos }}</td>
                                        <span class="badge" style="background:rgba(108,92,231,0.12);color:#6C5CE7;border-radius:20px;padding:4px 10px;font-weight:600;">{{ $cliente->Ciudad }}</span>
                                    <td>
                                        <i class="fas fa-phone text-muted mr-1"></i>{{ $cliente->telefono }}
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i>{{ $cliente->Direccion }}
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('cliente.show', $cliente->CUIT) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('cliente.edit', $cliente->CUIT) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('cliente.destroy', $cliente->CUIT) }}" 
                                                  method="post" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar este cliente?');">
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
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No hay clientes registrados</h5>
                                        <a href="{{ route('cliente.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus mr-1"></i>Agregar Primer Cliente
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($clientes->count())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Mostrando <strong>{{ $clientes->count() }}</strong> cliente(s)
                        </small>
                        <!-- Paginación si la tienes -->
                        {{-- {{ $clientes->links() }} --}}
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop


