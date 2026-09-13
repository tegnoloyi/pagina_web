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

    public function novedades()
    {
        $categories = Category::all();
        $products = Product::with(['images', 'variants'])
            ->where('is_new', true)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.novedades', compact('categories', 'products'));
    }

    public function ofertas()
    {
        $categories = Category::all();
        $products = Product::with(['images', 'variants'])
            ->whereNotNull('old_price')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.ofertas', compact('categories', 'products'));
    }

    // Vista Catálogo con filtros básicos
    public function catalog(Request $request)
    {
        $categories = Category::all();

        $query = Product::with(['images', 'variants']);

        if ($request->filled('category') && $request->category !== '') {
            $categoryRaw = $request->category;

            $category = Category::where('slug', $categoryRaw)->first();

            if ($category) {
                $query->where('category_id', $category->id);
            } elseif (ctype_digit((string) $categoryRaw)) {
                $query->where('category_id', (int) $categoryRaw);
            }
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