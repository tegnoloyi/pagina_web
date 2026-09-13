<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller
{
    // Vista Home (Página Principal)
    public function index()
    {
        $categories = Category::all();
        // Traemos productos destacados con sus imágenes y variantes
        $featuredProducts = Product::with(['images', 'variants'])->latest()->take(8)->get();

        return view('shop.index', compact('categories', 'featuredProducts'));
    }

    // Vista Catálogo con filtros básicos
    public function catalog(Request $request)
    {
        $categories = Category::all();

        $query = Product::with(['images', 'variants']);

        // Compatibilidad con la navegación del rediseño Scorpio:
        // category=nueva-coleccion = nuevas prendas (is_new)
        // sale=true = productos con old_price definido
        if ($request->filled('category') && $request->category !== '') {
            $categoryRaw = $request->category;

            if ($categoryRaw === 'nueva-coleccion') {
                $query->where('is_new', true);
            } else {
                $category = Category::where('slug', $categoryRaw)->first();

                if ($category) {
                    $query->where('category_id', $category->id);
                } elseif (ctype_digit((string) $categoryRaw)) {
                    $query->where('category_id', (int) $categoryRaw);
                }
            }
        }

        if ($request->boolean('sale')) {
            $query->whereNotNull('old_price');
        }

        if ($request->boolean('novedades') || $request->query('category') === 'nueva-coleccion') {
            $query->where('is_new', true);
        }

        $query->search($request->input('search'));

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('shop.catalog', compact('categories', 'products'));
    }

    // Ficha Detalle de Producto
    public function show($id)
    {
        $product = Product::with(['images', 'variants', 'category'])->findOrFail($id);

        return view('shop.show', compact('product'));
    }
}