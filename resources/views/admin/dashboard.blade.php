@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold uppercase tracking-wider">Dashboard</h1>
    <p class="text-xs text-gray-500 mt-1">Métricas generales, inventario y ventas.</p>
</div>

<!-- TARJETAS DE MÉTRICAS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-2">Ventas del Mes</span>
        <span class="text-3xl font-extrabold tracking-tight">${{ number_format($monthlySales, 2) }}</span>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-2">Órdenes Pendientes</span>
        <div class="flex items-baseline justify-between">
            <span class="text-3xl font-extrabold tracking-tight">{{ $pendingOrdersCount }}</span>
            <a href="{{ route('admin.orders.index', ['status' => 'pendiente']) }}" class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full hover:bg-amber-100">Ver</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-2">Alertas de Stock Bajo</span>
        <span class="text-3xl font-extrabold tracking-tight {{ $lowStockVariants->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">
            {{ $lowStockVariants->count() }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
    <!-- Pedidos por estatus -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wider mb-4">Pedidos por estatus</h2>
        <div class="space-y-2">
            @forelse($ordersByStatus as $status => $total)
            <div class="flex justify-between text-sm">
                <span class="capitalize text-gray-600">{{ $status }}</span>
                <span class="font-semibold">{{ $total }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400">Aún no hay pedidos.</p>
            @endforelse
        </div>
    </div>

    <!-- Top productos -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wider mb-4">Más vendidos</h2>
        <div class="space-y-2">
            @forelse($topProducts as $p)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">{{ $p->name }}</span>
                <span class="font-semibold">{{ $p->units_sold }} u. — ${{ number_format($p->revenue, 2) }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400">Aún no hay ventas registradas.</p>
            @endforelse
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
        <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold uppercase tracking-wider bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
            Gestionar productos
        </a>
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
                    <td class="px-6 py-4 font-mono text-gray-500">{{ $variant->sku }}</td>
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
                            <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 font-bold px-3 py-1 rounded-full">
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
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">No hay variantes registradas en el sistema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($variants->hasPages())
    <div class="p-4 border-t border-gray-100">{{ $variants->links() }}</div>
    @endif
</div>
@endsection
