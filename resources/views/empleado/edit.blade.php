@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-edit mr-2"></i>Editar Empleado</h1>
        <a href="{{ route('empleado.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Volver a la Lista
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="card-title mb-0"><i class="fas fa-user-edit mr-1"></i>Editando Empleado: {{ $empleado->idempleado }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('empleado.update', $empleado->idempleado) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idempleado" class="font-weight-bold">Código Empleado <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('idempleado') is-invalid @enderror" 
                                               id="idempleado" 
                                               name="idempleado" 
                                               value="{{ old('idempleado', $empleado->idempleado) }}" 
                                               placeholder="Ej: E0004"
                                               required readonly> {{-- Readonly porque es la clave primaria --}}
                                        @error('idempleado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">El código del empleado no puede ser modificado.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DNI" class="font-weight-bold">DNI <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('DNI') is-invalid @enderror" 
                                               id="DNI" 
                                               name="DNI" 
                                               value="{{ old('DNI', $empleado->DNI) }}" 
                                               placeholder="Ingrese el DNI"
                                               required>
                                        @error('DNI')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre" class="font-weight-bold">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('nombre') is-invalid @enderror" 
                                               id="nombre" 
                                               name="nombre" 
                                               value="{{ old('nombre', $empleado->nombre) }}" 
                                               placeholder="Ingrese el nombre"
                                               required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos" class="font-weight-bold">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('apellidos') is-invalid @enderror" 
                                               id="apellidos" 
                                               name="apellidos" 
                                               value="{{ old('apellidos', $empleado->apellidos) }}" 
                                               placeholder="Ingrese los apellidos"
                                               required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="telefono" class="font-weight-bold">Teléfono <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono', $empleado->telefono) }}" 
                                       placeholder="Ingrese el teléfono"
                                       required>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('empleado.index') }}" class="btn btn-secondary mr-2">
                                        <i class="fas fa-times mr-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>Actualizar Empleado
                                    </button>
                                </div>
                            </div>
                        </form>
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
        .form-group label {
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 0.3rem;
        }
        .btn {
            border-radius: 0.3rem;
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
            opacity: 1;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Formulario de edición de empleado cargado!");

        // Auto-formatear el DNI (solo números)
        document.getElementById('DNI').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@stop