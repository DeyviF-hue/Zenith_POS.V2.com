@extends('adminlte::page')

@section('title', isset($vrInventario) ? 'Editar Producto VR' : 'Nuevo Producto VR')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open text-primary mr-2"></i>{{ isset($vrInventario) ? 'Editar Producto VR' : 'Nuevo Producto VR' }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card" style="border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,0.05); border:none; border-top: 4px solid #6C5CE7;">
            <div class="card-body p-4">
                <form action="{{ isset($vrInventario) ? route('vr-inventario.update', $vrInventario->id) : route('vr-inventario.store') }}" method="POST">
                    @csrf
                    @if(isset($vrInventario)) @method('PUT') @endif

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>SKU (Código Barras/Identificador) <span class="text-danger">*</span></label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku', $vrInventario->sku ?? '') }}" required placeholder="EJ: AGU-001">
                            @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label>Nombre del Producto <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $vrInventario->nombre ?? '') }}" required>
                            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Categoría <span class="text-danger">*</span></label>
                            <select name="vr_categoria_id" class="form-control" required>
                                <option value="">Seleccione Categoría</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ old('vr_categoria_id', $vrInventario->vr_categoria_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label>Precio Unitario (S/) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', $vrInventario->precio ?? '') }}" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $vrInventario->stock ?? 0) }}" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Stock Mínimo (Alerta) <span class="text-danger">*</span></label>
                            <input type="number" name="stock_minimo" class="form-control" value="{{ old('stock_minimo', $vrInventario->stock_minimo ?? 5) }}" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Descripción (Opcional)</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $vrInventario->descripcion ?? '') }}</textarea>
                        </div>
                        
                        @if(isset($vrInventario) && !$vrInventario->activo)
                            <div class="col-md-12 mb-3">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Este producto está desactivado. Aún puedes editarlo, pero no aparecerá en el POS hasta reactivarlo (Aún no implementado en UI, hazlo vía base de datos).
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end mt-3 border-top pt-3">
                        <a href="{{ route('vr-inventario.index') }}" class="btn btn-light mr-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary" style="background:#6C5CE7; border:none;">
                            <i class="fas fa-save mr-1"></i> {{ isset($vrInventario) ? 'Actualizar Producto' : 'Guardar Producto' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
