@extends('adminlte::page')

@section('title', 'Venta Exitosa')

@section('content_header')
    <h1 class="m-0"><i class="fas fa-check-circle text-success mr-2"></i>Venta Exitosa</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card" style="border-radius: 12px; border-top: 4px solid #00b894; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div class="card-body text-center p-5">
                <div style="font-size: 5rem; color: #00b894; margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                
                <h3 style="font-weight: 700; color: #2d3436; margin-bottom: 10px;">¡Pago procesado con éxito!</h3>
                <p style="color: #636e72; font-size: 1.1rem; margin-bottom: 30px;">
                    El ticket <strong>{{ $venta->codigo }}</strong> ({{ strtoupper($venta->comprobante) }}) se generó correctamente bajo pago en {{ strtoupper($venta->metodo_pago) }}.
                </p>

                <div style="background: #f8f9fe; border-radius: 10px; padding: 20px; text-align: left; margin-bottom: 30px; border: 1px dashed #dfe6e9;">
                    <h5 style="color: var(--z-primary); font-weight: 600; border-bottom: 1px solid #dfe6e9; padding-bottom: 10px; margin-bottom: 15px;">Resumen</h5>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Cliente:</span>
                        <strong>{{ $venta->cliente ? $venta->cliente->Nombre : 'Consumidor Final' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Atendió:</span>
                        <strong>{{ $venta->user->name }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Artículos:</span>
                        <strong>{{ $venta->detalles->sum('cantidad') }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #dfe6e9;">
                        <span style="font-size: 1.2rem; font-weight: 600;">Total Cancelado:</span>
                        <strong style="font-size: 1.3rem; color: #00b894;">S/ {{ number_format($venta->total, 2) }}</strong>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-secondary btn-lg" onclick="window.print();" style="flex: 1; margin-right: 10px; border-radius: 10px;">
                        <i class="fas fa-print mr-2"></i>Imprimir Ticket
                    </button>
                    <a href="{{ route('ventas-rapidas.index') }}" class="btn btn-primary btn-lg" style="flex: 1; margin-left: 10px; border-radius: 10px; background: var(--z-primary); border: none;">
                        Nueva Venta <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop