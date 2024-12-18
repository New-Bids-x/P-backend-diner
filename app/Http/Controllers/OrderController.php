<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validated data is already available
            $validatedData = $request->validated();

            // Crear orden
            $order = Order::create([
                'nombre_cliente' => $validatedData['cliente']['nombre'],
                'telefono_cliente' => $validatedData['cliente']['telefono'],
                'email_cliente' => $validatedData['cliente']['email'] ?? null,
                'metodo_pago' => $validatedData['metodo_pago'],
                'total' => $validatedData['total'],
                'restaurante' => $validatedData['restaurante'],
                'direccion' => $validatedData['ubicacion']['direccion_completa'],
                'ubicacion' => $validatedData['ubicacion'] ?? null
            ]);

            // Crear items de la orden
            foreach ($validatedData['productos'] as $producto) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'producto_id' => $producto['id'],
                    'nombre_producto' => $producto['nombre'],
                    'cantidad' => $producto['cantidad'],
                    'precio' => $producto['precio']
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido creado exitosamente',
                'order_id' => $order->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el pedido',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            // Obtener todos los pedidos con sus items
            $orders = Order::with('items')->get();

            return response()->json([
                'success' => true,
                'orders' => $orders
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los pedidos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}