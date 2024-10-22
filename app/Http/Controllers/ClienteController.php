<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        if ($clientes->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron clientes',
                'status' => 200,
            ], 200);
        }

        return response()->json([
            'clientes' => $clientes,
            'status' => 200,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => 'required|email|unique:clientes',
            'telefono' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $cliente = Cliente::create($request->all());

        return response()->json([
            'cliente' => $cliente,
            'status' => 201,
        ], 201);
    }
}
