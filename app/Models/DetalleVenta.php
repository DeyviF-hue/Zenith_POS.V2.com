<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalles_ventas';
    protected $primaryKey = 'iddetalle';
    public $incrementing = true;

    protected $fillable = [
        'idventa',
        'idproducto',
        'cantidad'
    ];

    public $timestamps = false;

    // Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idventa', 'idventa');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto', 'idproducto');
    }
}