<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VrCategoria extends Model
{
    protected $table = 'vr_categorias';
    protected $fillable = ['nombre', 'icono', 'color'];

    public function productos()
    {
        return $this->hasMany(VrProducto::class, 'vr_categoria_id');
    }
}
