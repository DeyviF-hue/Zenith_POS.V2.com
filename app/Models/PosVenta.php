<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosVenta extends Model
{
    protected $table = 'pos_ventas';
    protected $fillable = [
        'codigo', 'cliente_cuit', 'user_id', 'subtotal', 'descuento',
        'igv', 'total', 'metodo_pago', 'estado_pago', 'comprobante', 'fecha'
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_cuit', 'CUIT');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(PosVentaDetalle::class, 'pos_venta_id');
    }
}