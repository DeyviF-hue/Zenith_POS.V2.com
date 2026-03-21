<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller  // ← LLAVE CORREGIDA
{
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('producto.producto', compact('productos')); // ← producto.producto
    }

    public function create()
    {
    $categorias = Categoria::all();
    return view('producto.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idproducto' => 'required|unique:productos,idproducto|max:5',
            'descripcion' => 'required|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'idcategoria' => 'required|exists:categorias,idcategoria'
        ]);

        try {
            Producto::create($request->all());
            return redirect()->route('producto.index')
                ->with('success', 'Producto creado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('producto.show', compact('producto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('producto.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'idcategoria' => 'required|exists:categorias,idcategoria'
        ]);

        try {
            $producto = Producto::findOrFail($id);
            $producto->update($request->all());
            return redirect()->route('producto.index')
                ->with('success', 'Producto actualizado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();

            return redirect()->route('producto.index')
                ->with('success', 'Producto eliminado exitosamente!');

        } catch (\Exception $e) {
            return redirect()->route('producto.index')
            ->with('error', 'Error al eliminar producto: ' . $e->getMessage());
        }
    }
}