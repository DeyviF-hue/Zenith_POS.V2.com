@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-edit mr-2"></i>Editar Cliente</h1>
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
                    <div class="card-header bg-warning">
                        <h3 class="card-title mb-0"><i class="fas fa-user-edit mr-1"></i>Editando Cliente: {{ $cliente->CUIT }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cliente.update', $cliente->CUIT) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="CUIT" class="font-weight-bold">CUIT <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('CUIT') is-invalid @enderror" 
                                               id="CUIT" 
                                               name="CUIT" 
                                               value="{{ old('CUIT', $cliente->CUIT) }}" 
                                               placeholder="Ingrese el CUIT"
                                               required readonly> {{-- Readonly porque es la clave primaria --}}
                                        @error('CUIT')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">El CUIT no puede ser modificado.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono" class="font-weight-bold">Teléfono <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('telefono') is-invalid @enderror" 
                                               id="telefono" 
                                               name="telefono" 
                                               value="{{ old('telefono', $cliente->telefono) }}" 
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
                                               value="{{ old('Nombre', $cliente->Nombre) }}" 
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
                                               value="{{ old('Apellidos', $cliente->Apellidos) }}" 
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
                                               value="{{ old('Ciudad', $cliente->Ciudad) }}" 
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
                                               value="{{ old('Direccion', $cliente->Direccion) }}" 
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
                                    <a href="{{ route('cliente.index') }}" class="btn btn-secondary mr-2">
                                        <i class="fas fa-times mr-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>Actualizar Cliente
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
        console.log("Formulario de edición de cliente cargado!");
    </script>
@stop