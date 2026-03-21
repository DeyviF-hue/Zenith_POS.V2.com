<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'idcategoria';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idcategoria',
        'nombre'
    ];

    public $timestamps = false;

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'idcategoria', 'idcategoria');
    }
}
