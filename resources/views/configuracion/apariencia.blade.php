@extends('adminlte::page')

@section('title', 'Apariencia')

@section('content_header')
    <h1><i class="fas fa-palette mr-2 text-primary"></i>Apariencia del Sistema</h1>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><i class="fas fa-sliders-h mr-1"></i> Personalizar Tema</div>
                <div class="card-body">
                    <form action="{{ route('configuracion.apariencia.guardar') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label>Color Primario (Botones, Links)</label>
                            <div class="input-group">
                                <input type="color" class="form-control" style="max-width: 60px; padding: 5px;" id="primaryColorPicker" value="{{ $settings['primary_color'] ?? '#6C5CE7' }}">
                                <input type="text" name="primary_color" id="primaryColorText" class="form-control text-uppercase" value="{{ $settings['primary_color'] ?? '#6C5CE7' }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label>Color de Sidebar (Fondo Oscuro)</label>
                            <div class="input-group">
                                <input type="color" class="form-control" style="max-width: 60px; padding: 5px;" id="sidebarColorPicker" value="{{ $settings['sidebar_color'] ?? '#2D2A3A' }}">
                                <input type="text" name="sidebar_color" id="sidebarColorText" class="form-control text-uppercase" value="{{ $settings['sidebar_color'] ?? '#2D2A3A' }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label>Color Acento (Submenús, Hovers)</label>
                            <div class="input-group">
                                <input type="color" class="form-control" style="max-width: 60px; padding: 5px;" id="accentColorPicker" value="{{ $settings['accent_color'] ?? '#A29BFE' }}">
                                <input type="text" name="accent_color" id="accentColorText" class="form-control text-uppercase" value="{{ $settings['accent_color'] ?? '#A29BFE' }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-2">
                            <i class="fas fa-save mr-1"></i> Guardar Apariencia
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header"><i class="fas fa-eye mr-1"></i> Vista Previa (Simulada)</div>
                <div class="card-body bg-light" style="border-radius: 0 0 12px 12px; min-height: 380px; display: flex; align-items: center; justify-content: center;">
                    <div style="width: 100%; max-width: 500px; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #E2E0FF;">
                        <!-- Preview Header -->
                        <div style="height: 50px; border-bottom: 1px solid #eee; display: flex; align-items: center; padding: 0 15px;">
                            <div style="width: 30px; height: 30px; border-radius: 6px; background: linear-gradient(135deg, var(--z-primary), var(--z-primary-l)); display: flex; align-items: center; justify-content: center; color: white;">⚡</div>
                            <div style="margin-left: 10px; font-weight: bold; color: var(--z-text);">ZENITH POS</div>
                        </div>
                        
                        <div style="display: flex; height: 260px;">
                            <!-- Preview Sidebar -->
                            <div style="width: 160px; background: var(--z-dark); padding: 15px 10px; color: rgba(255,255,255,0.7);">
                                <div style="font-size: 9px; font-weight: bold; letter-spacing: 1px; color: rgba(255,255,255,0.4); margin-bottom: 10px;">MENÚ PRINCIPAL</div>
                                <div style="padding: 8px 12px; background: var(--z-primary); color: white; border-radius: 6px; font-size: 13px; margin-bottom: 5px; font-weight: 500;"><i class="fas fa-chart-line mr-2"></i>Dashboard</div>
                                <div style="padding: 8px 12px; border-radius: 6px; font-size: 13px; margin-bottom: 5px;"><i class="fas fa-users mr-2"></i>Clientes</div>
                                <div style="padding: 8px 12px; border-radius: 6px; font-size: 13px; margin-bottom: 5px;"><i class="fas fa-box mr-2"></i>Productos</div>
                            </div>
                            
                            <!-- Preview Content -->
                            <div style="flex: 1; padding: 20px; background: #F4F3FF;">
                                <div style="font-size: 16px; font-weight: bold; color: var(--z-text); margin-bottom: 15px;">Dashboard</div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                                    <div style="background: linear-gradient(135deg, var(--z-primary), var(--z-primary-l)); height: 70px; border-radius: 8px; box-shadow: 0 4px 10px rgba(108,92,231,0.2);"></div>
                                    <div style="background: white; border: 1px solid #E2E0FF; height: 70px; border-radius: 8px;"></div>
                                </div>
                                <div style="background: var(--z-primary); color: white; text-align: center; padding: 8px; border-radius: 6px; font-size: 13px; font-weight: 600;">Completar Venta</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function syncColors(pickerId, textId, varName = null) {
        const picker = document.getElementById(pickerId);
        const text = document.getElementById(textId);

        picker.addEventListener('input', (e) => {
            text.value = e.target.value.toUpperCase();
            if (varName) document.documentElement.style.setProperty(varName, e.target.value);
        });

        text.addEventListener('input', (e) => {
            if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
                picker.value = e.target.value;
                if (varName) document.documentElement.style.setProperty(varName, e.target.value);
            }
        });
    }

    syncColors('primaryColorPicker', 'primaryColorText', '--z-primary');
    syncColors('sidebarColorPicker', 'sidebarColorText', '--z-dark');
    syncColors('accentColorPicker', 'accentColorText', '--z-primary-l');
</script>
@stop
