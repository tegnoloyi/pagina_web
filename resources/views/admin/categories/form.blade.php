@extends('layouts.admin')

@section('content')
<h1 class="mb-8 text-2xl font-bold uppercase tracking-wider">
    {{ $category->exists ? 'Editar categoría' : 'Nueva categoría' }}
</h1>

<form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      method="POST" class="max-w-lg space-y-4 rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6">
    @csrf
    @if($category->exists) @method('PUT') @endif

    <div>
        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
               class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
    </div>

    <div>
        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">URL de imagen</label>
        <input type="url" name="image_url" value="{{ old('image_url', $category->image_url) }}"
               class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-[var(--c-venom)] px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition hover:brightness-110">
            Guardar
        </button>
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">
            Cancelar
        </a>
    </div>
</form>
@endsection
