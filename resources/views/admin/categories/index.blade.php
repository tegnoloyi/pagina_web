@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold uppercase tracking-wider">Categorías</h1>
    <a href="{{ route('admin.categories.create') }}" class="text-xs font-semibold uppercase tracking-wider bg-black text-white px-4 py-2.5 rounded-lg hover:bg-gray-800">
        + Nueva categoría
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 uppercase text-gray-400 text-xs font-semibold border-b border-gray-100">
            <tr>
                <th class="px-6 py-3">Nombre</th>
                <th class="px-6 py-3">Slug</th>
                <th class="px-6 py-3">Productos</th>
                <th class="px-6 py-3 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $category)
            <tr>
                <td class="px-6 py-3 font-medium">{{ $category->name }}</td>
                <td class="px-6 py-3 text-gray-400 font-mono text-xs">{{ $category->slug }}</td>
                <td class="px-6 py-3">{{ $category->products_count }}</td>
                <td class="px-6 py-3 text-right space-x-3">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-semibold uppercase text-gray-600 hover:text-black">Editar</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-semibold uppercase text-red-500 hover:text-red-700">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No hay categorías todavía.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $categories->links() }}</div>
@endsection
