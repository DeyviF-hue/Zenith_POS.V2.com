<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    protected $primaryKey = 'idventa';
    public $incrementing = true;

    protected $fillable = [
        'fecha',
        'CUIT',
        'idasesor'
    ];

    public $timestamps = false;

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'CUIT', 'CUIT');
    }

    public function asesor()
    {
        return $this->belongsTo(AsesorVenta::class, 'idasesor', 'idasesor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'idventa', 'idventa');
    }
}