@extends('adminlte::page')

@section('title', 'Módulos del Sistema')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0"><i class="fas fa-puzzle-piece mr-2 text-primary"></i>Módulos del Sistema</h1>
            <small class="text-muted">Activa o desactiva módulos. Los módulos deshabilitados no aparecerán en el menú.</small>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        @foreach($modulos as $key => $modulo)
        <div class="col-md-4 mb-4">
            <div class="module-card {{ $modulo['habilitado'] ? '' : 'disabled' }}" id="card-{{ $key }}">
                <div class="module-icon">
                    <i class="{{ $modulo['icono'] }}"></i>
                </div>
                <div style="flex:1">
                    <div class="font-weight-bold" style="font-size:15px; color:#1F1D2E">
                        {{ $modulo['nombre'] }}
                    </div>
                    <div style="font-size:12px; color:#8B8A94; margin-top:3px;">
                        {{ $modulo['descripcion'] }}
                    </div>
                </div>
                <label class="zenith-toggle mb-0" title="{{ $modulo['habilitado'] ? 'Deshabilitar' : 'Habilitar' }}">
                    <input
                        type="checkbox"
                        class="toggle-modulo"
                        data-modulo="{{ $key }}"
                        {{ $modulo['habilitado'] ? 'checked' : '' }}
                    />
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        @endforeach
    </div>

    <div class="alert mt-2" style="background:#EEF0FF; border:1px solid #C8C4FF; color:#3D3952; border-radius:10px; font-size:13px;">
        <i class="fas fa-info-circle mr-1" style="color:#6C5CE7;"></i>
        Los cambios en los módulos requieren <strong>recargar la página</strong> para reflejarse en el menú lateral.
    </div>
</div>
@stop

@section('js')
<script>
document.querySelectorAll('.toggle-modulo').forEach(function(toggle) {
    toggle.addEventListener('change', function() {
        var key        = this.dataset.modulo;
        var habilitado = this.checked;
        var card       = document.getElementById('card-' + key);

        fetch('{{ url("configuracion/modulos/toggle") }}', {
            method : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ modulo: key, habilitado: habilitado })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                card.classList.toggle('disabled', !habilitado);
                var iconEl = card.querySelector('.module-icon');
                iconEl.style.background = habilitado
                    ? 'linear-gradient(135deg, #6C5CE7, #A29BFE)'
                    : '#e0e0e0';

                // Toast visual
                var toast = document.createElement('div');
                toast.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#6C5CE7;color:#fff;padding:12px 20px;border-radius:10px;font-size:14px;font-weight:600;z-index:9999;box-shadow:0 6px 20px rgba(108,92,231,0.4);transition:opacity 0.4s;';
                toast.textContent = habilitado ? '✓ Módulo habilitado' : '○ Módulo deshabilitado';
                document.body.appendChild(toast);
                setTimeout(() => { toast.style.opacity = '0'; }, 2000);
                setTimeout(() => { toast.remove(); }, 2500);
            }
        });
    });
});
</script>
@stop
