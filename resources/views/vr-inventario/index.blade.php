@extends('adminlte::page')

@section('title', 'Inventario POS Rápidas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="m-0" style="font-weight: 700; color: #2D2A3A;">
                <i class="fas fa-boxes mr-2" style="color: var(--z-primary);"></i>Inventario Ventas Rápidas
            </h1>
            <small class="text-muted">Catálogo independiente exclusivo para Ventas Rápidas</small>
        </div>
        <a href="{{ route('vr-inventario.create') }}" class="btn btn-primary" style="background: var(--z-primary); border: none; border-radius: 10px; padding: 10px 20px; font-weight: 600; box-shadow: 0 4px 15px rgba(108, 92, 231, 0.2);">
            <i class="fas fa-plus mr-1"></i> Nuevo Producto
        </a>
    </div>
@stop

@section('content')
<style>
    :root {
        --z-primary: {{ config('zenith.primary_color', '#6C5CE7') }};
        --z-dark: {{ config('zenith.sidebar_color', '#2D2A3A') }};
    }
    .z-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        border-top: 4px solid var(--z-primary);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .z-table th {
        background-color: #f8f9fa;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-top: none;
        border-bottom: 2px solid #edf2f7;
        padding: 16px;
    }
    .z-table td {
        vertical-align: middle;
        padding: 16px;
        color: #2D2A3A;
        border-top: 1px solid #edf2f7;
    }
    .btn-action {
        width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; transition: 0.2s;
    }
    .btn-action.edit { background: rgba(108, 92, 231, 0.1); color: var(--z-primary); }
    .btn-action.edit:hover { background: var(--z-primary); color: #fff; }
    .btn-action.delete { background: rgba(255, 118, 117, 0.1); color: #d63031; }
    .btn-action.delete:hover { background: #ff7675; color: #fff; }
    .stock-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
    .stock-good { background: rgba(0, 184, 148, 0.1); color: #00b894; }
    .stock-warning { background: rgba(253, 203, 110, 0.15); color: #e17055; }
    .stock-danger { background: rgba(255, 118, 117, 0.1); color: #d63031; }
    .filter-bar {
        background: #f8f9fa; padding: 15px; border-radius: 12px; margin-bottom: 20px;
    }
</style>

<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius: 10px;" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="z-card mb-4 p-3">
        <form method="GET" action="{{ route('vr-inventario.index') }}" class="row align-items-center m-0">
            <div class="col-md-5 mb-2 mb-md-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0" style="border-radius: 8px 0 0 8px;"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-left-0" style="border-radius: 0 8px 8px 0;" placeholder="Buscar por Nombre o SKU">
                </div>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <select name="categoria" class="form-control" style="border-radius: 8px;" onchange="this.form.submit()">
                    <option value="todos">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre }} ({{ $cat->productos_count }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{ route('vr-inventario.index') }}" class="btn btn-light" style="border-radius: 8px; font-weight: 500;">Limpiar Filtros</a>
            </div>
        </form>
    </div>

    <div class="z-card">
        <div class="table-responsive">
            <table class="table z-table">
                <thead>
                    <tr>
                        <th width="12%">SKU</th>
                        <th>Producto</th>
                        <th width="15%">Categoría</th>
                        <th width="12%">Precio</th>
                        <th width="12%">Stock</th>
                        <th width="10%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr style="opacity: {{ $producto->activo ? '1' : '0.5' }}">
                            <td>
                                <span style="background: #edf2f7; padding: 4px 8px; border-radius: 6px; font-family: monospace; font-size: 0.9rem; color: #4a5568;">
                                    {{ $producto->sku }}
                                </span>
                            </td>
                            <td>
                                <div class="font-weight-bold" style="font-size: 1rem;">{{ $producto->nombre }}</div>
                                @if(!$producto->activo)
                                    <span class="badge badge-secondary" style="font-size: 0.7rem;">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <span style="color: {{ $producto->categoria->color ?? '#718096' }}; font-size: 0.9rem; display: flex; align-items: center; gap: 6px;">
                                    <i class="{{ $producto->categoria->icono ?? 'fas fa-tag' }}"></i>
                                    {{ $producto->categoria ? $producto->categoria->nombre : 'Sin categoría' }}
                                </span>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: var(--z-primary); font-size: 1.05rem;">
                                    S/ {{ number_format($producto->precio, 2) }}
                                </span>
                            </td>
                            <td>
                                @if($producto->isOutOfStock())
                                    <span class="stock-badge stock-danger"><i class="fas fa-times-circle mr-1"></i>Agotado</span>
                                @elseif($producto->isLowStock())
                                    <span class="stock-badge stock-warning" title="Mínimo: {{ $producto->stock_minimo }}"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $producto->stock }}</span>
                                @else
                                    <span class="stock-badge stock-good"><i class="fas fa-check-circle mr-1"></i>{{ $producto->stock }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('vr-inventario.edit', $producto->id) }}" class="btn-action edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($producto->activo)
                                <form action="{{ route('vr-inventario.destroy', $producto->id) }}" method="post" class="d-inline" onsubmit="return confirm('¿Desactivar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Desactivar">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 60px 20px;">
                                <div style="color: #a0aec0; margin-bottom: 15px;">
                                    <i class="fas fa-box-open" style="font-size: 4rem; opacity: 0.5;"></i>
                                </div>
                                <h5 style="color: #4a5568; font-weight: 600;">Inventario Vacío</h5>
                                <p style="color: #718096; margin-bottom: 20px;">Agrega productos exclusivos para tu terminal de ventas rápidas.</p>
                                <a href="{{ route('vr-inventario.create') }}" class="btn btn-primary" style="background: var(--z-primary); border: none; border-radius: 8px;">
                                    Crear Producto
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($productos->hasPages())
        <div class="px-3 py-3 border-top">
            {{ $productos->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@stop
