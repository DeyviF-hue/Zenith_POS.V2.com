@extends('adminlte::page')

@section('title', 'Editar Proveedor')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-edit mr-2"></i>Editar Proveedor</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('proveedor.update', $proveedor->idproveedor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idproveedor">ID Proveedor</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $proveedor->idproveedor }}" readonly>
                                    <small class="text-muted">El ID no puede modificarse</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ruc">RUC</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $proveedor->ruc }}" readonly>
                                    <small class="text-muted">El RUC no puede modificarse</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre del Proveedor</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" 
                                   value="{{ old('nombre', $proveedor->nombre) }}" 
                                   maxlength="100" required>
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
                                           value="{{ old('telefono', $proveedor->telefono) }}" 
                                           maxlength="20" required>
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
                                           value="{{ old('direccion', $proveedor->direccion) }}" 
                                           maxlength="100" required>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Actualizar Proveedor
                            </button>
                            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop