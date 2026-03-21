<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
   public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedor.proveedor', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'idproveedor' => 'required|string|size:5|unique:proveedors,idproveedor',
            'nombre' => 'required|string|max:100',
            'ruc' => 'required|string|size:11|unique:proveedors,ruc',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:100',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedor.index')
            ->with('success', 'Proveedor creado exitosamente!');
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedor.show', compact('proveedor'));
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedor.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:100',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedor.index')
            ->with('success', 'Proveedor actualizado exitosamente!');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedor.index')
        ->with('success', 'Proveedor eliminado exitosamente!');
    }
}