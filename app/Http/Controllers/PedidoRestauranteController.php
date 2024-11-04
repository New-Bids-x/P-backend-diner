<?php

namespace App\Http\Controllers;

use App\Models\PedidoRestaurante;
use Illuminate\Http\Request;

class PedidoRestauranteController extends Controller
{


    public function index()
    {
        // Obtiene todos los pedidos de la base de datos
        $pedidos = PedidoRestaurante::all()->map(function ($pedido) {
            return [
                'id' => $pedido->id,
                'fecha' => $pedido->created_at->format('Y-m-d'),
                'hora' => $pedido->created_at->format('H:i:s'),
                'estado' => $pedido->estado,
                'pedido' => json_decode($pedido->pedido),
                'total' => $pedido->total,
            ];
        });

        // Retorna una respuesta JSON con la lista de pedidos
        return response()->json($pedidos);
    }



    public function store(Request $request)
    {
        // Valida los datos recibidos
        $validated = $request->validate([
            'pedido' => 'required|array',
            'total' => 'required|string',
        ]);

        // Crea un nuevo pedido en la base de datos
        $pedido = PedidoRestaurante::create([
            'pedido' => json_encode($validated['pedido']),
            'total' => $validated['total'],
        ]);

        // Retorna una respuesta
        return response()->json(['message' => 'Pedido guardado correctamente.', 'pedido' => $pedido], 201);
    }
}

