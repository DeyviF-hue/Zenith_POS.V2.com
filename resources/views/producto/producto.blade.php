@extends('adminlte::page')

@section('title', 'Gestión de Productos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="m-0" style="font-weight: 700; color: #2D2A3A;">
                <i class="fas fa-boxes mr-2" style="color: var(--z-primary);"></i>Catálogo de Productos
            </h1>
            <small class="text-muted">Administra el inventario disponible para Ventas Rápidas</small>
        </div>
        <a href="{{ route('producto.create') }}" class="btn btn-primary" style="background: var(--z-primary); border: none; border-radius: 10px; padding: 10px 20px; font-weight: 600; box-shadow: 0 4px 15px rgba(108, 92, 231, 0.2);">
            <i class="fas fa-plus mr-1"></i> Nuevo Producto
        </a>
    </div>
@stop

@section('content')
<style>
    :root {
        --z-primary: {{ config('zenith.primary_color', '#6C5CE7') }};
        --z-dark: {{ config('zenith.sidebar_color', '#2D2A3A') }};
        --z-accent: {{ config('zenith.accent_color', '#A29BFE') }};
    }
    
    .z-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        border-top: 4px solid var(--z-primary);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    
    .z-table {
        margin-bottom: 0;
    }
    .z-table th {
        background-color: #f8f9fa;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-top: none;
        border-bottom: 2px solid #edf2f7;
        padding: 16px;
    }
    .z-table td {
        vertical-align: middle;
        padding: 16px;
        color: #2D2A3A;
        font-size: 0.95rem;
        border-top: 1px solid #edf2f7;
    }
    .z-table tbody tr {
        transition: all 0.2s;
    }
    .z-table tbody tr:hover {
        background-color: #f8f9fe;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        border: none;
    }
    .btn-action.edit {
        background: rgba(108, 92, 231, 0.1);
        color: var(--z-primary);
    }
    .btn-action.edit:hover {
        background: var(--z-primary);
        color: #fff;
    }
    .btn-action.delete {
        background: rgba(255, 118, 117, 0.1);
        color: #d63031;
    }
    .btn-action.delete:hover {
        background: #ff7675;
        color: #fff;
    }
    
    .stock-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .stock-good { background: rgba(0, 184, 148, 0.1); color: #00b894; }
    .stock-warning { background: rgba(253, 203, 110, 0.15); color: #e17055; }
    .stock-danger { background: rgba(255, 118, 117, 0.1); color: #d63031; }
</style>

<div class="container-fluid">
    <div class="z-card">
        <div class="table-responsive">
            <table class="table z-table">
                <thead>
                    <tr>
                        <th width="10%">Código</th>
                        <th>Descripción del Producto</th>
                        <th width="15%">Categoría</th>
                        <th width="12%">Precio</th>
                        <th width="12%">Stock</th>
                        <th width="10%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>
                                <span style="background: #edf2f7; padding: 4px 8px; border-radius: 6px; font-family: monospace; font-size: 0.9rem; color: #4a5568;">
                                    {{ $producto->idproducto }}
                                </span>
                            </td>
                            <td class="font-weight-bold">{{ $producto->descripcion }}</td>
                            <td>
                                <span style="color: #718096; font-size: 0.9rem;">
                                    <i class="fas fa-tag mr-1" style="color: #cbd5e0;"></i>
                                    {{ $producto->categoria ? $producto->categoria->nombre : 'Sin categoría' }}
                                </span>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: var(--z-primary);">
                                    S/ {{ number_format($producto->precio, 2) }}
                                </span>
                            </td>
                            <td>
                                @if($producto->stock > 10)
                                    <span class="stock-badge stock-good"><i class="fas fa-check-circle mr-1"></i>{{ $producto->stock }}</span>
                                @elseif($producto->stock > 0)
                                    <span class="stock-badge stock-warning"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $producto->stock }}</span>
                                @else
                                    <span class="stock-badge stock-danger"><i class="fas fa-times-circle mr-1"></i>Agotado</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('producto.edit', $producto->idproducto) }}" class="btn-action edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('producto.destroy', $producto->idproducto) }}" method="post" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este producto? Esto puede afectar el historial de ventas.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 60px 20px;">
                                <div style="color: #a0aec0; margin-bottom: 15px;">
                                    <i class="fas fa-box-open" style="font-size: 4rem; opacity: 0.5;"></i>
                                </div>
                                <h5 style="color: #4a5568; font-weight: 600;">Tu inventario está vacío</h5>
                                <p style="color: #718096; margin-bottom: 20px;">Comienza agregando los productos que venderás en la caja rápida.</p>
                                <a href="{{ route('producto.create') }}" class="btn btn-primary" style="background: var(--z-primary); border: none; border-radius: 8px;">
                                    Ingresar mi primer producto
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($productos->count())
        <div style="padding: 16px 24px; border-top: 1px solid #edf2f7; background: #fdfdfe; color: #718096; font-size: 0.9rem;">
            Se encontraron <strong>{{ $productos->count() }}</strong> productos en el catálogo. Estos productos están listos para <strong>Ventas Rápidas</strong>.
        </div>
        @endif
    </div>
</div>
@stop