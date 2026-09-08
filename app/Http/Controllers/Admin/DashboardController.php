<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockThreshold = (int) config('shop.low_stock_threshold');

        $pendingOrdersCount = Order::where('status', 'pendiente')->count();

        $lowStockVariants = ProductVariant::with('product')
            ->where('stock', '<=', $lowStockThreshold)
            ->orderBy('stock')
            ->get();

        $monthlySales = Order::where('is_paid', true)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Top 5 productos más vendidos por unidades (histórico)
        $topProducts = OrderItem::query()
            ->join('product_variants', 'order_items.variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.qty) as units_sold'), DB::raw('SUM(order_items.qty * order_items.unit_price) as revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('units_sold')
            ->take(5)
            ->get();

        // Ventas de los últimos 14 días (para graficar en el front si se quiere)
        $salesLast14Days = Order::where('is_paid', true)
            ->where('created_at', '>=', now()->subDays(14)->startOfDay())
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(total) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $variants = ProductVariant::with('product')->latest()->paginate(15);

        return view('admin.dashboard', compact(
            'pendingOrdersCount',
            'lowStockVariants',
            'monthlySales',
            'ordersByStatus',
            'topProducts',
            'salesLast14Days',
            'variants'
        ));
    }
}
