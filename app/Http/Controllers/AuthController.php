<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Usuario registrado exitosamente'], 201);
    }

    public function login(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar con las credenciales
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        // Si las credenciales son correctas, obtenemos al usuario autenticado
        $user = Auth::user();

        // Creamos el token de autenticación (si estás usando Sanctum o Passport)
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolvemos el token y los datos del usuario
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'message' => 'Inicio sesión exitosamente',
        ], 200);
    }



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function checkSession(Request $request)
    {
        $token = $request->bearerToken();  // Obtener el token de la cabecera

        // Si el token existe, intentar obtener al usuario
        if ($token) {
            $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token);

            if ($user) {
                return response()->json([
                    'isAuthenticated' => true,
                    'message' => 'Sesión activa'
                ]);
            } else {
                return response()->json([
                    'isAuthenticated' => false,
                    'message' => 'No se pudo autenticar el token'
                ]);
            }
        } else {
            return response()->json([
                'isAuthenticated' => false,
                'message' => 'Token no proporcionado'
            ]);
        }
    }


}
