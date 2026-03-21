@extends('adminlte::page')

@section('title', 'Nuevo Cliente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-user-plus mr-2"></i>Nuevo Cliente</h1>
        <a href="{{ route('cliente.index') }}" class="btn btn-secondary btn-sm">
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
                        <h3 class="card-title mb-0"><i class="fas fa-user-circle mr-1"></i>Información del Cliente</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cliente.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="CUIT" class="font-weight-bold">CUIT <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('CUIT') is-invalid @enderror" 
                                               id="CUIT" 
                                               name="CUIT" 
                                               value="{{ old('CUIT') }}" 
                                               placeholder="Ingrese el CUIT"
                                               required>
                                        @error('CUIT')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Ejemplo: CL004, CL005</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nombre" class="font-weight-bold">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('Nombre') is-invalid @enderror" 
                                               id="Nombre" 
                                               name="Nombre" 
                                               value="{{ old('Nombre') }}" 
                                               placeholder="Ingrese el nombre"
                                               required>
                                        @error('Nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Apellidos" class="font-weight-bold">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('Apellidos') is-invalid @enderror" 
                                               id="Apellidos" 
                                               name="Apellidos" 
                                               value="{{ old('Apellidos') }}" 
                                               placeholder="Ingrese los apellidos"
                                               required>
                                        @error('Apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Ciudad" class="font-weight-bold">Ciudad <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('Ciudad') is-invalid @enderror" 
                                               id="Ciudad" 
                                               name="Ciudad" 
                                               value="{{ old('Ciudad') }}" 
                                               placeholder="Ingrese la ciudad"
                                               required>
                                        @error('Ciudad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Direccion" class="font-weight-bold">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('Direccion') is-invalid @enderror" 
                                               id="Direccion" 
                                               name="Direccion" 
                                               value="{{ old('Direccion') }}" 
                                               placeholder="Ingrese la dirección completa"
                                               required>
                                        @error('Direccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="reset" class="btn btn-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i>Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>Guardar Cliente
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
        console.log("Formulario de nuevo cliente cargado!");

        // Opcional: Podemos agregar alguna validación en el frontend
        document.addEventListener('DOMContentLoaded', function() {
            // Ejemplo: Formatear automáticamente el CUIT
            const cuitInput = document.getElementById('CUIT');
            if (cuitInput) {
                cuitInput.addEventListener('input', function(e) {
                    this.value = this.value.toUpperCase();
                });
            }
        });
    </script>
@stop