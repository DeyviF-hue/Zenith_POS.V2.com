@extends('adminlte::page')

@section('title', 'Lista de Proveedores')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-truck mr-2"></i>Proveedores</h1>
        <a href="{{ route('proveedor.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>Nuevo Proveedor
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th width="150px" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proveedores as $proveedor)
                        <tr>
                            <td class="font-weight-bold text-primary">{{ $proveedor->idproveedor }}</td>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->ruc }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('proveedor.edit', $proveedor->idproveedor) }}" 
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('proveedor.destroy', $proveedor->idproveedor) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                title="Eliminar"
                                                onclick="return confirm('¿Está seguro de eliminar este proveedor?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay proveedores registrados</h5>
                                <a href="{{ route('proveedor.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus mr-1"></i>Registrar Primer Proveedor
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
        .btn-group .btn {
            margin: 0 2px;
        }
    </style>
@stop