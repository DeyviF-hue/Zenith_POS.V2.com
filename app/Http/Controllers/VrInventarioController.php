<?php

namespace App\Http\Controllers;

use App\Models\VrProducto;
use App\Models\VrCategoria;
use Illuminate\Http\Request;

class VrInventarioController extends Controller
{
    public function index(Request $request)
    {
        $categorias = VrCategoria::withCount(['productos' => function($q) {
            $q->where('activo', true);
        }])->get();

        $query = VrProducto::with('categoria')->where('activo', true);

        if ($request->filled('categoria') && $request->categoria !== 'todos') {
            $query->where('vr_categoria_id', $request->categoria);
        }

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->q . '%')
                  ->orWhere('sku', 'like', '%' . $request->q . '%');
            });
        }

        $productos = $query->orderBy('nombre')->paginate(20)->withQueryString();

        return view('vr-inventario.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = VrCategoria::all();
        return view('vr-inventario.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku'             => 'required|unique:vr_productos,sku|max:30',
            'nombre'          => 'required|max:120',
            'vr_categoria_id' => 'required|exists:vr_categorias,id',
            'precio'          => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'stock_minimo'    => 'required|integer|min:0',
            'descripcion'     => 'nullable|max:300',
        ]);

        VrProducto::create($request->only([
            'sku', 'nombre', 'descripcion', 'vr_categoria_id',
            'precio', 'stock', 'stock_minimo'
        ]));

        return redirect()->route('vr-inventario.index')
            ->with('success', "Producto \"{$request->nombre}\" agregado al inventario.");
    }

    public function edit(VrProducto $vrInventario)
    {
        $categorias = VrCategoria::all();
        return view('vr-inventario.edit', compact('vrInventario', 'categorias'));
    }

    public function update(Request $request, VrProducto $vrInventario)
    {
        $request->validate([
            'sku'             => 'required|max:30|unique:vr_productos,sku,' . $vrInventario->id,
            'nombre'          => 'required|max:120',
            'vr_categoria_id' => 'required|exists:vr_categorias,id',
            'precio'          => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'stock_minimo'    => 'required|integer|min:0',
            'descripcion'     => 'nullable|max:300',
        ]);

        $vrInventario->update($request->only([
            'sku', 'nombre', 'descripcion', 'vr_categoria_id',
            'precio', 'stock', 'stock_minimo'
        ]));

        return redirect()->route('vr-inventario.index')
            ->with('success', "Producto \"{$vrInventario->nombre}\" actualizado.");
    }

    public function destroy(VrProducto $vrInventario)
    {
        $nombre = $vrInventario->nombre;
        // Soft-delete: just mark as inactive
        $vrInventario->update(['activo' => false]);

        return redirect()->route('vr-inventario.index')
            ->with('success', "Producto \"{$nombre}\" desactivado del inventario.");
    }

    // AJAX: buscar para el POS
    public function buscar(Request $request)
    {
        $term = $request->get('q', '');
        $categoriaId = $request->get('categoria');

        $query = VrProducto::with('categoria')
            ->where('activo', true)
            ->where('stock', '>', 0);

        if ($categoriaId && $categoriaId !== 'todos') {
            $query->where('vr_categoria_id', $categoriaId);
        }

        if ($term) {
            $query->where(function($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            });
        }

        $productos = $query->orderBy('nombre')->limit(30)->get();

        return response()->json($productos->map(fn($p) => [
            'id'          => $p->id,
            'sku'         => $p->sku,
            'nombre'      => $p->nombre,
            'precio'      => $p->precio,
            'stock'       => $p->stock,
            'categoria'   => $p->categoria ? $p->categoria->nombre : '-',
            'cat_color'   => $p->categoria ? $p->categoria->color : '#6C5CE7',
            'cat_id'      => $p->vr_categoria_id,
        ]));
    }
}
