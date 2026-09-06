<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\Product;

class AdminController extends Controller
{
    // Dashboard Administrativo
    public function index()
    {
        // 1. Tarjetas de Métricas
        $pendingOrdersCount = Order::where('status', 'pendiente')->count();
        
        // Alertas de stock bajo (variantes con 3 o menos piezas)
        $lowStockVariants = ProductVariant::with('product')->where('stock', '<=', 3)->get();
        
        // Ventas del mes actual (simulado o calculado)
        $monthlySales = Order::where('status', '!=', 'cancelado')
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        // 2. Tabla interactiva de variantes de inventario para el Admin
        $variants = ProductVariant::with('product')->latest()->paginate(15);

        return view('admin.dashboard', compact(
            'pendingOrdersCount', 
            'lowStockVariants', 
            'monthlySales', 
            'variants'
        ));
    }
}