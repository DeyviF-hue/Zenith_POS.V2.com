@extends('adminlte::page')

@section('title', 'Configuración General')

@section('content_header')
    <h1><i class="fas fa-sliders-h mr-2 text-primary"></i>Configuración General del Sistema</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><i class="fas fa-info-circle mr-1"></i> Información del Sistema</div>
        <div class="card-body">
            <table class="table table-borderless" style="font-size:14px;">
                <tr><td class="text-muted font-weight-bold" style="width:200px">Nombre del sistema</td><td>Zenith POS</td></tr>
                <tr><td class="text-muted font-weight-bold">Versión</td><td>2.0.0</td></tr>
                <tr><td class="text-muted font-weight-bold">Entorno</td><td><span class="badge badge-success">{{ config('app.env') }}</span></td></tr>
                <tr><td class="text-muted font-weight-bold">URL de la aplicación</td><td>{{ config('app.url') }}</td></tr>
                <tr><td class="text-muted font-weight-bold">Zona horaria</td><td>{{ config('app.timezone') }}</td></tr>
                <tr><td class="text-muted font-weight-bold">Base de datos</td><td>{{ config('database.default') }} &mdash; {{ config('database.connections.' . config('database.default') . '.database') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@stop
