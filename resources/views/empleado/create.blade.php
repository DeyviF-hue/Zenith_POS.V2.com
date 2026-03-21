@extends('adminlte::page')

@section('title', 'Nuevo Empleado')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-user-plus mr-2"></i>Nuevo Empleado</h1>
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
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0"><i class="fas fa-user-circle mr-1"></i>Información del Empleado</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('empleado.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idempleado" class="font-weight-bold">Código Empleado <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('idempleado') is-invalid @enderror" 
                                               id="idempleado" 
                                               name="idempleado" 
                                               value="{{ old('idempleado') }}" 
                                               placeholder="Ej: E0004"
                                               required>
                                        @error('idempleado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Ejemplo: E0004, E0005</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DNI" class="font-weight-bold">DNI <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('DNI') is-invalid @enderror" 
                                               id="DNI" 
                                               name="DNI" 
                                               value="{{ old('DNI') }}" 
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
                                               value="{{ old('nombre') }}" 
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
                                               value="{{ old('apellidos') }}" 
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
                                       value="{{ old('telefono') }}" 
                                       placeholder="Ingrese el teléfono"
                                       required>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="reset" class="btn btn-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i>Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>Guardar Empleado
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
    </style>
@stop

@section('js')
    <script>
        console.log("Formulario de nuevo empleado cargado!");

        // Auto-formatear el código del empleado a mayúsculas
        document.getElementById('idempleado').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        // Auto-formatear el DNI (solo números)
        document.getElementById('DNI').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@stop