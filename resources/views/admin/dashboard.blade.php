@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- ENCABEZADO ADMIN -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold uppercase tracking-wider">Panel Administrativo</h1>
            <p class="text-xs text-gray-500 mt-1">Control de inventario por SKU, métricas y gestión de stock.</p>
        </div>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider bg-black text-white px-4 py-2.5 rounded-lg hover:bg-gray-800 transition w-max">
            ← Volver a la Tienda
        </a>
    </div>

    <!-- TARJETAS DE MÉTRICAS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Tarjeta 1: Ventas del Mes -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-2">Ventas del Mes</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold tracking-tight">${{ number_format($monthlySales, 2) }}</span>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">+12.5%</span>
            </div>
        </div>

        <!-- Tarjeta 2: Órdenes Pendientes -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-2">Órdenes Pendientes</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold tracking-tight">{{ $pendingOrdersCount }}</span>
                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Requiere Atención</span>
            </div>
        </div>

        <!-- Tarjeta 3: Alertas de Stock Bajo -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-2">Alertas de Stock Bajo</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold tracking-tight {{ $lowStockVariants->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">
                    {{ $lowStockVariants->count() }}
                </span>
                <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full">≤ 3 Unidades</span>
            </div>
        </div>
    </div>

    <!-- TABLA DE VARIANTES E INVENTARIO SKU -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-base font-semibold uppercase tracking-wider">Gestión de Variantes y SKUs</h2>
                <p class="text-xs text-gray-400">Inventario directo por combinación de talla y color.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 uppercase text-gray-400 font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Producto</th>
                        <th class="px-6 py-4">SKU Único</th>
                        <th class="px-6 py-4">Talla</th>
                        <th class="px-6 py-4">Color</th>
                        <th class="px-6 py-4">Precio Variant</th>
                        <th class="px-6 py-4 text-center">Stock Disponible</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($variants as $variant)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $variant->product->name ?? 'Producto no encontrado' }}
                        </td>
                        <td class="px-6 py-4 font-mono text-gray-500">
                            {{ $variant->sku }}
                        </td>
                        <td class="px-6 py-4 font-semibold">
                            <span class="bg-gray-100 px-2.5 py-1 rounded-md">{{ $variant->size }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 rounded-full border border-gray-300 shadow-sm" style="background-color: {{ $variant->color_hex ?? '#000' }};"></span>
                                <span>{{ $variant->color }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            ${{ number_format($variant->price ?? $variant->product->base_price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($variant->stock <= 3)
                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 font-bold px-3 py-1 rounded-full animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                    {{ $variant->stock }} piezas
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 font-semibold px-3 py-1 rounded-full">
                                    {{ $variant->stock }} piezas
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                            No hay variantes registradas en el sistema.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($variants->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $variants->links() }}
        </div>
        @endif
    </div>

</div>
@endsection