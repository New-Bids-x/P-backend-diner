<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No hay ventas registradas', 'status' => 200], 200);
        }

        return response()->json(['ventas' => $ventas, 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'administrador_id' => 'required|integer|exists:administrador,id',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'cliente' => 'required|string|max:255',
            'estado' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $venta = Venta::create($request->all());

        return response()->json(['venta' => $venta, 'status' => 201], 201);
    }

    public function show($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada', 'status' => 404], 404);
        }

        return response()->json(['venta' => $venta, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada', 'status' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'administrador_id' => 'integer|exists:administrador,id',
            'monto' => 'numeric',
            'fecha' => 'date',
            'cliente' => 'string|max:255',
            'estado' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $venta->update($request->all());

        return response()->json(['message' => 'Venta actualizada', 'venta' => $venta, 'status' => 200], 200);
    }

    public function destroy($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada', 'status' => 404], 404);
        }

        $venta->delete();

        return response()->json(['message' => 'Venta eliminada', 'status' => 200], 200);
    }
}
