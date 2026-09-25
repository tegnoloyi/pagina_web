@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-bold uppercase tracking-wider">Productos</h1>
    <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-[var(--c-venom)] px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition hover:brightness-110">
        + Nuevo producto
    </a>
</div>

<form method="GET" class="mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar producto..."
           class="w-64 rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
    <select name="category" class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2 text-sm text-[var(--c-bone)]">
        <option value="">Todas las categorías</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (string) request('category') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button class="rounded-lg bg-[var(--c-surface-2)] px-4 py-2 text-xs font-semibold uppercase tracking-wider text-[var(--c-bone)] hover:opacity-90">Filtrar</button>
</form>

<div class="overflow-hidden rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)]">
    <div class="overflow-x-auto">
    <table class="w-full min-w-[640px] text-left text-sm">
        <thead class="border-b border-[var(--c-line)] bg-[var(--c-surface-2)] text-xs font-semibold uppercase text-[var(--c-bone-dim)]">
            <tr>
                <th class="px-6 py-3">Producto</th>
                <th class="px-6 py-3">Categoría</th>
                <th class="px-6 py-3">Precio</th>
                <th class="px-6 py-3">Stock total</th>
                <th class="px-6 py-3 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--c-line)]">
            @forelse($products as $product)
            <tr>
                <td class="flex items-center gap-3 px-6 py-3 font-medium text-[var(--c-bone)]">
                    <div class="h-12 w-10 flex-shrink-0 overflow-hidden rounded bg-[var(--c-surface-2)]">
                        @if($product->images->first())
                            <img src="{{ $product->images->first()->url }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    {{ $product->name }}
                </td>
                <td class="px-6 py-3 text-[var(--c-bone-dim)]">{{ $product->category->name ?? '—' }}</td>
                <td class="px-6 py-3 text-[var(--c-bone)]">${{ number_format($product->base_price, 2) }}</td>
                <td class="px-6 py-3 text-[var(--c-bone)]">{{ $product->totalStock() }}</td>
                <td class="space-x-3 px-6 py-3 text-right">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-semibold uppercase text-[var(--c-bone-dim)] hover:text-[var(--c-bone)]">Editar</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-semibold uppercase text-red-500 hover:text-red-700">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-[var(--c-bone-dim)]">No hay productos todavía.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<div class="mt-6 text-[var(--c-bone)]">{{ $products->links() }}</div>
@endsection
