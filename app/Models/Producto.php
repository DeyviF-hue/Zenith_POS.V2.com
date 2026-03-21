<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'idproducto';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idproducto',
        'descripcion',
        'precio',
        'stock',
        'idcategoria'
    ];

    public $timestamps = false;

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idcategoria', 'idcategoria');
    }
}