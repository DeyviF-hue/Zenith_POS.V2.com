<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\SystemModule;
use App\Models\SystemSetting;

class ConfiguracionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* ─── Módulos ──────────────────────────────────────── */

    public function modulos()
    {
        $modulos = config('modulos');
        return view('configuracion.modulos', compact('modulos'));
    }

    public function toggleModulo(Request $request)
    {
        $moduloKey  = $request->input('modulo');
        $habilitado = $request->boolean('habilitado');

        // Actualizar base de datos
        $module = SystemModule::where('module_key', $moduloKey)->first();
        if ($module) {
            $module->enabled = $habilitado;
            $module->save();
        }

        return response()->json(['success' => true, 'habilitado' => $habilitado]);
    }

    /* ─── Usuarios ─────────────────────────────────────── */

    public function usuarios()
    {
        $usuarios = \App\Models\User::all();
        return view('configuracion.usuarios', compact('usuarios'));
    }

    /* ─── Configuración general ────────────────────────── */

    public function sistema()
    {
        return view('configuracion.sistema');
    }

    /* ─── Apariencia ───────────────────────────────────── */

    public function apariencia()
    {
        $settings = config('zenith');
        return view('configuracion.apariencia', compact('settings'));
    }

    public function guardarApariencia(Request $request)
    {
        $data = $request->validate([
            'primary_color' => 'required|string|max:20',
            'sidebar_color' => 'required|string|max:20',
            'accent_color'  => 'required|string|max:20',
        ]);

        foreach ($data as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('configuracion.apariencia')->with('success', 'La apariencia ha sido actualizada.');
    }
}
