<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nombre_cliente',
        'telefono_cliente',
        'email_cliente',
        'metodo_pago',
        'total',
        'restaurante',
        'direccion',
        'ubicacion',
        'estado'
    ];

    protected $casts = [
        'ubicacion' => 'array'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

// app/Models/OrderItem.php
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'producto_id',
        'nombre_producto',
        'cantidad',
        'precio'
    ];
}