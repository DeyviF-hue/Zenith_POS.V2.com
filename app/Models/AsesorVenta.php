<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesorVenta extends Model
{
    use HasFactory;

    protected $table = 'asesores_ventas';
    protected $primaryKey = 'idasesor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idasesor',
        'idempleado'
    ];

    public $timestamps = false;

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'idempleado', 'idempleado');
    }

    // Relación con ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idasesor', 'idasesor');
    }
}