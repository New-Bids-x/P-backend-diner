<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['products' => $products]);
    }
    public function index2()
    {
        // Obtener todos los productos
        $products = Product::all();

        // Agrupar productos por categoría
        $groupedProducts = $products->groupBy('categoria')->map(function ($items, $categoria) {
            return [
                'categoria' => $categoria,
                'productos' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->nombre,
                        'precio' => $item->precio,
                        'imagen' => $item->imagen,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                    ];
                }),
            ];
        });

        // Retornar los productos agrupados
        return response()->json(['categories' => $groupedProducts->values()]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'categoria' => 'nullable|string|max:255'
        ]);

        $productData = $request->only(['nombre', 'precio', 'categoria']);

        if ($request->hasFile('imagen')) {
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);
            $productData['imagen'] = $imageName;
        }

        $product = Product::create($productData);

        return response()->json(['message' => 'Producto guardado con éxito', 'product' => $product]);
    }

    public function deleteAll()
    {
        $products = Product::all();

        foreach ($products as $product) {
            if ($product->imagen && file_exists(public_path('images/' . $product->imagen))) {
                unlink(public_path('images/' . $product->imagen));
            }
        }

        Product::truncate();

        return response()->json(['message' => 'Todos los productos y sus imágenes fueron eliminados con éxito']);
    }
}
