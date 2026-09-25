@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold uppercase tracking-wider">Dashboard</h1>
    <p class="mt-1 text-xs text-[var(--c-bone-dim)]">Métricas generales, inventario y ventas.</p>
</div>

<div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">
    <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6 shadow-sm">
        <span class="mb-2 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Ventas del Mes</span>
        <span class="text-3xl font-extrabold tracking-tight text-[var(--c-bone)]">${{ number_format($monthlySales, 2) }}</span>
    </div>

    <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6 shadow-sm">
        <span class="mb-2 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Órdenes Pendientes</span>
        <div class="flex items-baseline justify-between gap-3">
            <span class="text-3xl font-extrabold tracking-tight text-[var(--c-bone)]">{{ $pendingOrdersCount }}</span>
            <a href="{{ route('admin.orders.index', ['status' => 'pendiente']) }}" class="rounded-full bg-amber-500/10 px-2 py-1 text-xs font-medium text-amber-600 hover:bg-amber-500/15 dark:text-amber-300">Ver</a>
        </div>
    </div>

    <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6 shadow-sm">
        <span class="mb-2 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Alertas de Stock Bajo</span>
        <span class="text-3xl font-extrabold tracking-tight {{ $lowStockVariants->count() > 0 ? 'text-red-600 dark:text-red-400' : 'text-[var(--c-bone)]' }}">
            {{ $lowStockVariants->count() }}
        </span>
    </div>
</div>

<div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-[var(--c-bone)]">Pedidos por estatus</h2>
        <div class="space-y-2">
            @forelse($ordersByStatus as $status => $total)
            <div class="flex justify-between text-sm">
                <span class="capitalize text-[var(--c-bone-dim)]">{{ $status }}</span>
                <span class="font-semibold text-[var(--c-bone)]">{{ $total }}</span>
            </div>
            @empty
            <p class="text-sm text-[var(--c-bone-dim)]">Aún no hay pedidos.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-[var(--c-bone)]">Más vendidos</h2>
        <div class="space-y-2">
            @forelse($topProducts as $p)
            <div class="flex justify-between gap-3 text-sm">
                <span class="text-[var(--c-bone-dim)]">{{ $p->name }}</span>
                <span class="font-semibold text-[var(--c-bone)]">{{ $p->units_sold }} u. — ${{ number_format($p->revenue, 2) }}</span>
            </div>
            @empty
            <p class="text-sm text-[var(--c-bone-dim)]">Aún no hay ventas registradas.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] shadow-sm">
    <div class="flex flex-col gap-3 border-b border-[var(--c-line)] p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-base font-semibold uppercase tracking-wider text-[var(--c-bone)]">Gestión de Variantes y SKUs</h2>
            <p class="text-xs text-[var(--c-bone-dim)]">Inventario directo por combinación de talla y color.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-block rounded-lg bg-[var(--c-venom)] px-4 py-2 text-center text-xs font-semibold uppercase tracking-wider text-white transition hover:brightness-110">
            Gestionar productos
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="border-b border-[var(--c-line)] bg-[var(--c-surface-2)] uppercase text-[var(--c-bone-dim)] font-semibold">
                <tr>
                    <th class="px-6 py-4">Producto</th>
                    <th class="px-6 py-4">SKU Único</th>
                    <th class="px-6 py-4">Talla</th>
                    <th class="px-6 py-4">Color</th>
                    <th class="px-6 py-4">Precio Variant</th>
                    <th class="px-6 py-4 text-center">Stock Disponible</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--c-line)]">
                @forelse($variants as $variant)
                <tr class="transition hover:bg-[var(--c-surface-2)]/70">
                    <td class="px-6 py-4 font-medium text-[var(--c-bone)]">
                        {{ $variant->product->name ?? 'Producto no encontrado' }}
                    </td>
                    <td class="px-6 py-4 font-mono text-[var(--c-bone-dim)]">{{ $variant->sku }}</td>
                    <td class="px-6 py-4 font-semibold text-[var(--c-bone)]">
                        <span class="rounded-md bg-[var(--c-surface-2)] px-2.5 py-1">{{ $variant->size }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-[var(--c-bone)]">
                            <span class="h-3.5 w-3.5 rounded-full border border-[var(--c-line)] shadow-sm" style="background-color: {{ $variant->color_hex ?? '#000' }};"></span>
                            <span>{{ $variant->color }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-[var(--c-bone)]">
                        ${{ number_format($variant->price ?? $variant->product->base_price, 2) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($variant->stock <= 3)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 font-bold text-red-700 dark:bg-red-500/15 dark:text-red-300">
                                {{ $variant->stock }} piezas
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">
                                {{ $variant->stock }} piezas
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-[var(--c-bone-dim)]">No hay variantes registradas en el sistema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($variants->hasPages())
    <div class="border-t border-[var(--c-line)] p-4 text-[var(--c-bone)]">{{ $variants->links() }}</div>
    @endif
</div>
@endsection