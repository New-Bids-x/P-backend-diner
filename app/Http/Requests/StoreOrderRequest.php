<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cliente.nombre' => 'nullable|string|max:255',
            'cliente.telefono' => 'nullable|string|max:20',
            'cliente.email' => 'nullable|email|max:255',
            'metodo_pago' => 'nullable|in:tarjeta,efectivo,paypal',
            'total' => 'nullable|numeric|min:0',
            'restaurante' => 'nullable|string|max:255',
            'ubicacion.direccion_completa' => 'nullable|string',
            'ubicacion.coordenadas' => 'nullable|string',
            'ubicacion.pais' => 'nullable|string|max:255',
            'ubicacion.ciudad' => 'nullable|string|max:255',
            'ubicacion.barrio' => 'nullable|string|max:255',
            'ubicacion.referencia' => 'nullable|string|max:255',
            'productos' => 'nullable|array|min:1',
            'productos.*.id' => 'nullable|integer',
            'productos.*.nombre' => 'nullable|string',
            'productos.*.cantidad' => 'nullable|integer|min:1',
            'productos.*.precio' => 'nullable|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'cliente.nombre.max' => 'El nombre del cliente no puede exceder 255 caracteres.',
            'cliente.telefono.max' => 'El teléfono del cliente no puede exceder 20 caracteres.',
            'cliente.email.email' => 'El correo electrónico debe ser una dirección válida.',
            'metodo_pago.in' => 'El método de pago no es válido.',
            'total.numeric' => 'El total debe ser un número.',
            'total.min' => 'El total no puede ser un valor negativo.',
            'ubicacion.direccion_completa.max' => 'La dirección completa no puede exceder 255 caracteres.',
            'productos.*.id.integer' => 'El ID del producto debe ser un número entero.',
            'productos.*.cantidad.min' => 'La cantidad mínima de un producto es 1.',
            'productos.*.precio.min' => 'El precio de un producto debe ser un número positivo.',
        ];
    }
}
