<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'CUIT';
    public $incrementing = false;
    protected $keyType = 'string';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'CUIT',
        'Nombre',
        'Apellidos', 
        'Ciudad',
        'telefono',
        'Direccion'
    ];

    public $timestamps = false; 
}
