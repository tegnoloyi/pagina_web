@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-bold uppercase tracking-wider">Categorías</h1>
    <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-[var(--c-venom)] px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition hover:brightness-110">
        + Nueva categoría
    </a>
</div>

<div class="overflow-hidden rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)]">
    <div class="overflow-x-auto">
    <table class="w-full min-w-[560px] text-left text-sm">
        <thead class="border-b border-[var(--c-line)] bg-[var(--c-surface-2)] text-xs font-semibold uppercase text-[var(--c-bone-dim)]">
            <tr>
                <th class="px-6 py-3">Nombre</th>
                <th class="px-6 py-3">Slug</th>
                <th class="px-6 py-3">Productos</th>
                <th class="px-6 py-3 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--c-line)]">
            @forelse($categories as $category)
            <tr>
                <td class="px-6 py-3 font-medium text-[var(--c-bone)]">{{ $category->name }}</td>
                <td class="px-6 py-3 font-mono text-xs text-[var(--c-bone-dim)]">{{ $category->slug }}</td>
                <td class="px-6 py-3 text-[var(--c-bone)]">{{ $category->products_count }}</td>
                <td class="space-x-3 px-6 py-3 text-right">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-semibold uppercase text-[var(--c-bone-dim)] hover:text-[var(--c-bone)]">Editar</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-semibold uppercase text-red-500 hover:text-red-700">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-[var(--c-bone-dim)]">No hay categorías todavía.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<div class="mt-6 text-[var(--c-bone)]">{{ $categories->links() }}</div>
@endsection
