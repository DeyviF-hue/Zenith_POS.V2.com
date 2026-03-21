@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-edit mr-2"></i>Editar Producto</h1>
        <a href="{{ route('producto.index') }}" class="btn btn-secondary btn-sm">
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
                        <h3 class="card-title mb-0"><i class="fas fa-edit mr-1"></i>Editando Producto: {{ $producto->idproducto }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('producto.update', $producto->idproducto) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idproducto" class="font-weight-bold">Código Producto <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('idproducto') is-invalid @enderror" 
                                               id="idproducto" 
                                               name="idproducto" 
                                               value="{{ old('idproducto', $producto->idproducto) }}" 
                                               placeholder="Ej: PR012"
                                               required readonly> {{-- Readonly porque es la clave primaria --}}
                                        @error('idproducto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">El código del producto no puede ser modificado.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idcategoria" class="font-weight-bold">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-control @error('idcategoria') is-invalid @enderror" 
                                                id="idcategoria" 
                                                name="idcategoria" 
                                                required>
                                            <option value="">Seleccione categoría</option>
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->idcategoria }}" {{ old('idcategoria', $producto->idcategoria) == $categoria->idcategoria ? 'selected' : '' }}>
                                                    {{ $categoria->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('idcategoria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descripcion" class="font-weight-bold">Descripción <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('descripcion') is-invalid @enderror" 
                                       id="descripcion" 
                                       name="descripcion" 
                                       value="{{ old('descripcion', $producto->descripcion) }}" 
                                       placeholder="Ingrese la descripción del producto"
                                       required>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio" class="font-weight-bold">Precio (S/) <span class="text-danger">*</span></label>
                                        <input type="number" 
                                               step="0.01" 
                                               class="form-control @error('precio') is-invalid @enderror" 
                                               id="precio" 
                                               name="precio" 
                                               value="{{ old('precio', $producto->precio) }}" 
                                               placeholder="0.00"
                                               required>
                                        @error('precio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock" class="font-weight-bold">Stock <span class="text-danger">*</span></label>
                                        <input type="number" 
                                               class="form-control @error('stock') is-invalid @enderror" 
                                               id="stock" 
                                               name="stock" 
                                               value="{{ old('stock', $producto->stock) }}" 
                                               placeholder="0"
                                               required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('producto.index') }}" class="btn btn-secondary mr-2">
                                        <i class="fas fa-times mr-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>Actualizar Producto
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
        console.log("Formulario de edición de producto cargado!");
    </script>
@stop