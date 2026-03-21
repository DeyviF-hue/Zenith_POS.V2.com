<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VrProducto extends Model
{
    protected $table = 'vr_productos';
    protected $fillable = [
        'sku', 'nombre', 'descripcion', 'vr_categoria_id',
        'precio', 'stock', 'stock_minimo', 'imagen', 'activo'
    ];

    public function categoria()
    {
        return $this->belongsTo(VrCategoria::class, 'vr_categoria_id');
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->stock_minimo && $this->stock > 0;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }
}
