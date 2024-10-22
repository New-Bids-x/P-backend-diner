<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;

use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/administradores', [AdministradorController::class, 'index']);
Route::post('/administradores', [AdministradorController::class, 'store']);
Route::get('/administradores/{id}', [AdministradorController::class, 'show']);
Route::put('/administradores/{id}', [AdministradorController::class, 'update']);
Route::patch('/administradores/{id}', [AdministradorController::class, 'updatePartial']);
Route::delete('/administradores/{id}', [AdministradorController::class, 'delete']);

Route::apiResource('venta', VentaController::class);

Route::get('/clientes', [ClienteController::class, 'index']);
Route::post('/clientes', [ClienteController::class, 'store']);


Route::apiResource('pedido', PedidoController::class);