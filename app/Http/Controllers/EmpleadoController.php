<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleado.empleado', compact('empleados'));
    }

    public function create()
    {
        return view('empleado.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'idempleado' => 'required|unique:empleados,idempleado|max:5',
            'nombre' => 'required|max:20',
            'apellidos' => 'required|max:20',
            'DNI' => 'required|unique:empleados,DNI|max:8',
            'telefono' => 'required|max:9'
        ]);

        try {
            Empleado::create($request->all());
            return redirect()->route('empleado.index')
                ->with('success', 'Empleado creado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear empleado: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:20',
            'apellidos' => 'required|max:20',
            'telefono' => 'required|max:9'
        ]);

        try {
            $empleado = Empleado::findOrFail($id);
            $empleado->update($request->all());
            return redirect()->route('empleado.index')
            ->with('success', 'Empleado actualizado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()
            ->with('error', 'Error al actualizar empleado: ' . $e->getMessage())
            ->withInput();
        }
    }
}