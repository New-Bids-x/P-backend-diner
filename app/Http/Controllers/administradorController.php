<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class administradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::all();
        if ($administradores->isEmpty()) {
            $data = [
                'message' => 'No administrator found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }
        $data = [
            'administradores' => $administradores,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => 'required|email|unique:administrador',
            'password' => 'required|min:6',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|max:255',
            'usuario' => 'required|unique:administrador',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $administrador = Administrador::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'usuario' => $request->usuario,
            'estado' => $request->estado ?? 'activo', // Default to 'activo' if not provided
        ]);

        $data = [
            'administrador' => $administrador,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            $data = [
                'message' => 'Administrator not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'administrador' => $administrador,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            $data = [
                'message' => 'Administrator not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $administrador->delete();
        $data = [
            'message' => 'Administrator deleted',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            $data = [
                'message' => 'Administrator not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => 'required|email|unique:administrador,email,' . $id,
            'password' => 'required|min:6',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|max:255',
            'usuario' => 'required|unique:administrador,usuario,' . $id,
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $administrador->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'usuario' => $request->usuario,
            'estado' => $request->estado ?? $administrador->estado,
        ]);

        $data = [
            'message' => 'Administrator updated',
            'administrador' => $administrador,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            $data = [
                'message' => 'Administrator not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'max:255',
            'apellido' => 'max:255',
            'email' => 'email|unique:administrador,email,' . $id,
            'password' => 'min:6',
            'telefono' => 'max:20',
            'direccion' => 'max:255',
            'usuario' => 'unique:administrador,usuario,' . $id,
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombre')) {
            $administrador->nombre = $request->nombre;
        }
        if ($request->has('apellido')) {
            $administrador->apellido = $request->apellido;
        }
        if ($request->has('email')) {
            $administrador->email = $request->email;
        }
        if ($request->has('password')) {
            $administrador->password = Hash::make($request->password);
        }
        if ($request->has('telefono')) {
            $administrador->telefono = $request->telefono;
        }
        if ($request->has('direccion')) {
            $administrador->direccion = $request->direccion;
        }
        if ($request->has('usuario')) {
            $administrador->usuario = $request->usuario;
        }
        if ($request->has('estado')) {
            $administrador->estado = $request->estado;
        }

        $administrador->save();

        $data = [
            'message' => 'Administrator partially updated',
            'administrador' => $administrador,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
