<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Ingrediente;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Inicio del procesamiento del producto.');

        // Validación de datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredientes' => 'required|array',
            'ingredientes.*.nombre' => 'required|string|max:255',
            'ingredientes.*.imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Guardar la imagen principal del producto y obtener la ruta
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('public/productos');
            $imagenUrl = str_replace('public/', 'storage/', $imagenPath); // URL para mostrar la imagen
        }

        // Crear el producto en la base de datos
        $producto = Producto::create([
            'nombre' => $request->input('nombre'),
            'precio' => $request->input('precio'),
            'imagen' => $imagenUrl,
        ]);

        \Log::info('Producto guardado: ' . $producto->id);

        // Guardar cada ingrediente con su imagen
        foreach ($request->ingredientes as $index => $ingredienteData) {
            if (isset($ingredienteData['imagen']) && $request->hasFile("ingredientes.$index.imagen")) {
                $ingredienteImagePath = $request->file("ingredientes.$index.imagen")->store('public/ingredientes');
                $ingredienteImageUrl = str_replace('public/', 'storage/', $ingredienteImagePath);
            } else {
                $ingredienteImageUrl = null;
            }

            // Crear cada ingrediente en la base de datos asociado al producto
            $producto->ingredientes()->create([
                'nombre' => $ingredienteData['nombre'],
                'imagen' => $ingredienteImageUrl,
            ]);

            \Log::info("Ingrediente {$index} guardado para el producto: " . $producto->id);
        }

        \Log::info('Producto y sus ingredientes procesados con éxito.');

        // Retornar la respuesta
        return response()->json([
            'message' => 'Producto y ingredientes guardados exitosamente',
            'producto' => $producto->load('ingredientes')
        ], 201);
    }


    public function show($id)
    {
        $producto = Producto::with('ingredientes')->findOrFail($id);
        return response()->json($producto);
    }
}
