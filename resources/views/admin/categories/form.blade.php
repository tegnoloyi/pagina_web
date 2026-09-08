@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold uppercase tracking-wider mb-8">
    {{ $category->exists ? 'Editar categoría' : 'Nueva categoría' }}
</h1>

<form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      method="POST" class="bg-white rounded-2xl border border-gray-100 p-6 max-w-lg space-y-4">
    @csrf
    @if($category->exists) @method('PUT') @endif

    <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
    </div>

    <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">URL de imagen</label>
        <input type="url" name="image_url" value="{{ old('image_url', $category->image_url) }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-black text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-lg hover:bg-gray-800">
            Guardar
        </button>
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-500 px-6 py-2.5">
            Cancelar
        </a>
    </div>
</form>
@endsection
