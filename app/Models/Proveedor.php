<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedors';
    protected $primaryKey = 'idproveedor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idproveedor',
        'nombre', 
        'ruc',
        'telefono',
        'direccion'
    ];

    public $timestamps = false;
}