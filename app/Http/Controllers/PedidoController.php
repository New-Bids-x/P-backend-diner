<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        if ($pedidos->isEmpty()) {
            return response()->json(['message' => 'No hay pedidos encontrados', 'status' => 200], 200);
        }
        return response()->json(['pedidos' => $pedidos, 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|integer|exists:clientes,id', // Asegúrate de tener la tabla clientes
            'monto' => 'required|numeric',
            'estado' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $pedido = Pedido::create([
            'cliente_id' => $request->cliente_id,
            'monto' => $request->monto,
            'estado' => $request->estado,
        ]);

        return response()->json(['pedido' => $pedido, 'status' => 201], 201);
    }

    public function show($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado', 'status' => 404], 404);
        }
        return response()->json(['pedido' => $pedido, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado', 'status' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'monto' => 'nullable|numeric',
            'estado' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        if ($request->has('monto')) {
            $pedido->monto = $request->monto;
        }
        if ($request->has('estado')) {
            $pedido->estado = $request->estado;
        }

        $pedido->save();

        return response()->json(['pedido' => $pedido, 'status' => 200], 200);
    }

    public function delete($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado', 'status' => 404], 404);
        }

        $pedido->delete();
        return response()->json(['message' => 'Pedido eliminado', 'status' => 200], 200);
    }
}
