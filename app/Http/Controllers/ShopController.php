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

        // Filtrar por categoría si viene en la URL
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
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