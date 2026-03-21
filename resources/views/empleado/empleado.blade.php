@extends('adminlte::page')

@section('title', 'Gestión de Empleados')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-users mr-2"></i>Gestión de Empleados</h1>
        <a href="{{ route('empleado.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle mr-1"></i>Nuevo Empleado
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0"><i class="fas fa-list mr-1"></i>Lista de Empleados</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="10%">Código</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>DNI</th>
                                <th>Teléfono</th>
                                <th width="15%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $empleado)
                                <tr>
                                    <td class="font-weight-bold text-primary">{{ $empleado->idempleado }}</td>
                                    <td>{{ $empleado->nombre }}</td>
                                    <td>{{ $empleado->apellidos }}</td>
                                    <td><span class="badge badge-secondary">{{ $empleado->DNI }}</span></td>
                                    <td>
                                        <i class="fas fa-phone text-muted mr-1"></i>{{ $empleado->telefono }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('empleado.edit', $empleado->idempleado) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('empleado.destroy', $empleado->idempleado) }}" 
                                                  method="post" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar este empleado?');">
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
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No hay empleados registrados</h5>
                                        <a href="{{ route('empleado.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus mr-1"></i>Agregar Primer Empleado
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($empleados->count())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Mostrando <strong>{{ $empleados->count() }}</strong> empleado(s)
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