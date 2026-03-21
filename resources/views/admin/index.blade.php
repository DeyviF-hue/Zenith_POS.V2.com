@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0"><i class="fas fa-tachometer-alt mr-2 text-primary"></i>Dashboard</h1>
            <small class="text-muted">Bienvenido al panel de control de Zenith POS</small>
        </div>
        <div>
            <span class="badge" style="background:rgba(108,92,231,0.12);color:#6C5CE7;font-size:12px;padding:7px 14px;border-radius:20px;font-weight:600;">
                <i class="fas fa-circle mr-1" style="font-size:8px;"></i>Sistema activo
            </span>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row mt-2">
        {{-- Módulos habilitados como tarjetas de acceso rápido --}}
        @if(config('modulos.ventas-rapidas.habilitado', true))
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100" style="border-top: 3px solid #6C5CE7 !important;">
                <div class="card-body d-flex align-items-center" style="gap:16px;">
                    <div style="width:50px;height:50px;background:linear-gradient(135deg,#6C5CE7,#A29BFE);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-cash-register text-white fa-lg"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#8B8A94;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Ventas Rápidas</div>
                        <a href="{{ url('ventas-rapidas') }}" style="font-size:14px;color:#6C5CE7;font-weight:600;text-decoration:none;">Ir a cobrar →</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(config('modulos.clientes.habilitado', true))
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100" style="border-top: 3px solid #6C5CE7 !important;">
                <div class="card-body d-flex align-items-center" style="gap:16px;">
                    <div style="width:50px;height:50px;background:linear-gradient(135deg,#6C5CE7,#A29BFE);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-users text-white fa-lg"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#8B8A94;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Clientes</div>
                        <a href="{{ url('cliente') }}" style="font-size:14px;color:#6C5CE7;font-weight:600;text-decoration:none;">Ver lista →</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(config('modulos.productos.habilitado', true))
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100" style="border-top: 3px solid #6C5CE7 !important;">
                <div class="card-body d-flex align-items-center" style="gap:16px;">
                    <div style="width:50px;height:50px;background:linear-gradient(135deg,#6C5CE7,#A29BFE);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-box text-white fa-lg"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#8B8A94;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Productos</div>
                        <a href="{{ url('producto') }}" style="font-size:14px;color:#6C5CE7;font-weight:600;text-decoration:none;">Ver catálogo →</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(config('modulos.ventas.habilitado', true))
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100" style="border-top: 3px solid #6C5CE7 !important;">
                <div class="card-body d-flex align-items-center" style="gap:16px;">
                    <div style="width:50px;height:50px;background:linear-gradient(135deg,#6C5CE7,#A29BFE);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-shopping-cart text-white fa-lg"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#8B8A94;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Ventas</div>
                        <a href="{{ url('venta') }}" style="font-size:14px;color:#6C5CE7;font-weight:600;text-decoration:none;">Ver historial →</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(config('modulos.empleados.habilitado', true))
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100" style="border-top: 3px solid #6C5CE7 !important;">
                <div class="card-body d-flex align-items-center" style="gap:16px;">
                    <div style="width:50px;height:50px;background:linear-gradient(135deg,#6C5CE7,#A29BFE);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-user-tie text-white fa-lg"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;color:#8B8A94;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Empleados</div>
                        <a href="{{ url('empleado') }}" style="font-size:14px;color:#6C5CE7;font-weight:600;text-decoration:none;">Ver lista →</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Accesos rápidos --}}
    @if(config('modulos.ventas.habilitado', true))
    <div class="row mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt mr-1" style="color:#6C5CE7;"></i>
                    <strong>Acciones Rápidas</strong>
                </div>
                <div class="card-body" style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="{{ url('venta/create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Nueva Venta
                    </a>
                    <a href="{{ route('venta.mes') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-chart-line mr-1"></i>Ventas del Mes
                    </a>
                    <a href="{{ route('venta.historial') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-history mr-1"></i>Historial Completo
                    </a>
                    @if(config('modulos.clientes.habilitado', true))
                    <a href="{{ url('cliente/create') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-user-plus mr-1"></i>Nuevo Cliente
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@stop