<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all(); // variable PLURAL
        return view('cliente.cliente', compact('clientes')); // 'tipoemps' con S
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'CUIT' => 'required|unique:clientes,CUIT|max:15',
            'Nombre' => 'required|max:25',
            'Apellidos' => 'required|max:25',
            'Ciudad' => 'required|max:50',
            'telefono' => 'required|max:9',
            'Direccion' => 'required|max:150'
        ], [
            'CUIT.unique' => 'Este CUIT ya está registrado',
            'Nombre.required' => 'El nombre es obligatorio',
        ]);

        try {
            // Crear el nuevo cliente
            Cliente::create($request->all());

            return redirect()->route('cliente.index')
                ->with('success', 'Cliente creado exitosamente!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear cliente: ' . $e->getMessage())
                ->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $CUIT)
    {
        $cliente = Cliente::findOrFail($CUIT);
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $CUIT)
    {
    $request->validate([
        // Nota: No validamos CUIT como único porque es el mismo
        'Nombre' => 'required|max:25',
        'Apellidos' => 'required|max:25',
        'Ciudad' => 'required|max:50',
        'telefono' => 'required|max:9',
        'Direccion' => 'required|max:150'
    ]);

    try {
        $cliente = Cliente::findOrFail($CUIT);
        $cliente->update($request->all());

        return redirect()->route('cliente.index')
            ->with('success', 'Cliente actualizado exitosamente!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al actualizar cliente: ' . $e->getMessage())
            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($CUIT)
    {
    try {
        $cliente = Cliente::findOrFail($CUIT);
        $cliente->delete();

        return redirect()->route('cliente.index')
            ->with('success', 'Cliente eliminado exitosamente!');

    } catch (\Exception $e) {
        return redirect()->route('cliente.index')
            ->with('error', 'Error al eliminar cliente: ' . $e->getMessage());
        }
    }
}
