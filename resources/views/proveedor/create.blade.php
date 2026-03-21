@extends('adminlte::page')

@section('title', 'Registrar Proveedor')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-truck mr-2"></i>Registrar Nuevo Proveedor</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('proveedor.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idproveedor">ID Proveedor <small class="text-muted">(5 caracteres)</small></label>
                                    <input type="text" class="form-control @error('idproveedor') is-invalid @enderror" 
                                           id="idproveedor" name="idproveedor" 
                                           value="{{ old('idproveedor') }}" 
                                           maxlength="5" required
                                           placeholder="Ej: PR001">
                                    @error('idproveedor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ruc">RUC <small class="text-muted">(11 dígitos)</small></label>
                                    <input type="text" class="form-control @error('ruc') is-invalid @enderror" 
                                           id="ruc" name="ruc" 
                                           value="{{ old('ruc') }}" 
                                           maxlength="11" required
                                           placeholder="Ej: 12345678901">
                                    @error('ruc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre del Proveedor</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   maxlength="100" required
                                   placeholder="Ej: Distribuidora XYZ S.A.">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                           id="telefono" name="telefono" 
                                           value="{{ old('telefono') }}" 
                                           maxlength="20" required
                                           placeholder="Ej: 987654321">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                                           id="direccion" name="direccion" 
                                           value="{{ old('direccion') }}" 
                                           maxlength="100" required
                                           placeholder="Ej: Av. Principal 123">
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Guardar Proveedor
                            </button>
                            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle mr-1"></i>Información</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <small>
                            • El <strong>ID Proveedor</strong> debe tener exactamente 5 caracteres.<br>
                            • El <strong>RUC</strong> debe tener 11 dígitos.<br>
                            • Todos los campos son obligatorios.
                        </small>
                    </p>
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
    </style>
@stop