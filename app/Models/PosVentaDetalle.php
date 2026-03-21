<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosVentaDetalle extends Model
{
    protected $table = 'pos_venta_detalles';
    protected $fillable = [
        'pos_venta_id', 'vr_producto_id', 'cantidad',
        'precio_unitario', 'descuento', 'subtotal'
    ];

    public function posVenta()
    {
        return $this->belongsTo(PosVenta::class);
    }

    public function producto()
    {
        return $this->belongsTo(VrProducto::class, 'vr_producto_id');
    }
}
