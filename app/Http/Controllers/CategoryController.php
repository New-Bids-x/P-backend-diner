<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $category = Category::create(['nombre' => $request->nombre]);

        return response()->json(['category' => $category], 201);
    }

    public function getProductsByCategory($id)
    {
        try {
            // Buscar la categoría por ID
            $category = Category::findOrFail($id);

            // Obtener los productos de la categoría
            $products = $category->products;

            // Retornar los productos en formato JSON
            return response()->json([
                'success' => true,
                'category' => $category->nombre,
                'products' => $products
            ], 200);
        } catch (\Exception $e) {
            // En caso de error, devolver una respuesta de error
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada o error al obtener los productos.',
            ], 404);
        }
    }

}
