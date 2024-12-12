<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'imagen', 'producto_id'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
