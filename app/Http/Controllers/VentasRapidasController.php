<?php

namespace App\Http\Controllers;

use App\Models\PosVenta;
use App\Models\PosVentaDetalle;
use App\Models\VrProducto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentasRapidasController extends Controller
{
    /**
     * Muestra la interfaz del POS (carrito de compras).
     */
    public function index()
    {
        // Solo pasar la lista de clientes para el selector (opcional)
        $clientes = Cliente::all();
        return view('ventas-rapidas.index', compact('clientes'));
    }

    /**
     * Buscar productos por descripción (ahora manejado por VrInventarioController)
     */
    public function buscarProductos(Request $request)
    {
        return redirect()->route('vr-inventario.buscar.pos', $request->all());
    }

    /**
     * Procesar la venta y guardarla en base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_cuit' => 'nullable|string|max:15',
            'cliente_nombre' => 'nullable|string|max:100', // Capturado desde el modal
            'comprobante' => 'required|in:boleta,factura',
            'metodo_pago' => 'required|in:efectivo,yape,plin,qr',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:vr_productos,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.descuento' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Crear o actualizar cliente si se proporciona el DNI o nombre
            $clienteDni = $request->cliente_cuit;
            if ($clienteDni) {
                // Generar nombre por defecto si no lo ingresan
                $nombre = $request->cliente_nombre ?: 'Cliente ' . $clienteDni;
                \App\Models\Cliente::updateOrCreate(
                    ['CUIT' => $clienteDni],
                    [
                        'Nombre' => $nombre,
                        'Apellidos' => '-',
                        'Ciudad' => '-',
                        'telefono' => '-',
                        'Direccion' => '-'
                    ]
                );
            }

            // Generar código único de venta
            $ultimaVenta = PosVenta::latest('id')->first();
            $nuevoId = $ultimaVenta ? $ultimaVenta->id + 1 : 1;
            $codigo = 'VR-' . date('Ymd') . '-' . str_pad($nuevoId, 5, '0', STR_PAD_LEFT);

            // Calcular totales
            $subtotal = 0;
            $totalDescuento = 0;
            foreach ($request->items as $item) {
                $lineaSubtotal = $item['cantidad'] * $item['precio_unitario'];
                $lineaDescuento = $item['descuento'] ?? 0;
                $subtotal += $lineaSubtotal;
                $totalDescuento += $lineaDescuento;
            }
            $subtotalConDescuento = $subtotal - $totalDescuento;
            $igv = $subtotalConDescuento * 0.18; // 18% IGV
            $total = $subtotalConDescuento + $igv;

            // Crear la venta
            $venta = PosVenta::create([
                'codigo' => $codigo,
                'cliente_cuit' => $request->cliente_cuit,
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'descuento' => $totalDescuento, // guardamos el descuento total
                'igv' => $igv,
                'total' => $total,
                'metodo_pago' => $request->metodo_pago,
                'estado_pago' => 'pagado',
                'comprobante' => $request->comprobante,
                'fecha' => now(),
            ]);

            // Guardar detalles y actualizar stock
            foreach ($request->items as $item) {
                $producto = VrProducto::find($item['id']);
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}");
                }

                PosVentaDetalle::create([
                    'pos_venta_id' => $venta->id,
                    'vr_producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'descuento' => $item['descuento'] ?? 0,
                    'subtotal' => ($item['cantidad'] * $item['precio_unitario']) - ($item['descuento'] ?? 0),
                ]);

                // Reducir stock
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            DB::commit();
            return redirect()->route('ventas-rapidas.show', $venta->id)
                             ->with('success', 'Venta registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Mostrar el detalle de una venta (comprobante).
     */
    public function show($id)
    {
        $venta = PosVenta::with(['cliente', 'user', 'detalles.producto'])->findOrFail($id);
        return view('ventas-rapidas.show', compact('venta'));
    }
}