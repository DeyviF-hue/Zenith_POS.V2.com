<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'idempleado';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idempleado',
        'nombre',
        'apellidos',
        'DNI',
        'telefono'
    ];

    public $timestamps = false;

    // Relación con asesores de ventas
    public function asesorVentas()
    {
        return $this->hasMany(AsesorVenta::class, 'idempleado', 'idempleado');
    }
}