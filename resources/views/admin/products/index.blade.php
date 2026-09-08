@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold uppercase tracking-wider">Productos</h1>
    <a href="{{ route('admin.products.create') }}" class="text-xs font-semibold uppercase tracking-wider bg-black text-white px-4 py-2.5 rounded-lg hover:bg-gray-800">
        + Nuevo producto
    </a>
</div>

<form method="GET" class="flex gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar producto..."
           class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-64">
    <select name="category" class="border border-gray-200 rounded-lg px-4 py-2 text-sm">
        <option value="">Todas las categorías</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (string) request('category') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button class="text-xs font-semibold uppercase tracking-wider bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">Filtrar</button>
</form>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 uppercase text-gray-400 text-xs font-semibold border-b border-gray-100">
            <tr>
                <th class="px-6 py-3">Producto</th>
                <th class="px-6 py-3">Categoría</th>
                <th class="px-6 py-3">Precio</th>
                <th class="px-6 py-3">Stock total</th>
                <th class="px-6 py-3 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr>
                <td class="px-6 py-3 font-medium flex items-center gap-3">
                    <div class="w-10 h-12 rounded bg-gray-100 overflow-hidden flex-shrink-0">
                        @if($product->images->first())
                            <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{ $product->name }}
                </td>
                <td class="px-6 py-3 text-gray-500">{{ $product->category->name ?? '—' }}</td>
                <td class="px-6 py-3">${{ number_format($product->base_price, 2) }}</td>
                <td class="px-6 py-3">{{ $product->totalStock() }}</td>
                <td class="px-6 py-3 text-right space-x-3">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-semibold uppercase text-gray-600 hover:text-black">Editar</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-semibold uppercase text-red-500 hover:text-red-700">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay productos todavía.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
