<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\LogoutUserRequest;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedUserController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $user = Administrador::where("email", $request->emailuser)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "msg" => ["Las credenciales son invalidas"]
            ]);w
        }

        $token = $user->createToken($request->emailuser)->plainTextToken;

        return response()->json([
            "msg" => "Inicio de sesión exitoso",
            "user" => $user,
            "token" => $token
        ]);
    }

    public function logout(LogoutUserRequest $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'msg' => 'Cierre de sesión exitoso'
        ]);
    }
}