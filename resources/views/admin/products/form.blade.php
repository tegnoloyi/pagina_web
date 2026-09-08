@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold uppercase tracking-wider mb-8">
    {{ $product->exists ? 'Editar producto' : 'Nuevo producto' }}
</h1>

<form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
      method="POST" enctype="multipart/form-data" class="space-y-8 max-w-3xl">
    @csrf
    @if($product->exists) @method('PUT') @endif

    <!-- Datos generales -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Datos generales</h2>

        <div>
            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Categoría</label>
            <select name="category_id" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        </div>

        <div>
            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Descripción</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Material</label>
                <input type="text" name="material" value="{{ old('material', $product->material) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Precio base</label>
                <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Precio anterior</label>
                <input type="number" step="0.01" name="old_price" value="{{ old('old_price', $product->old_price) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
            Marcar como "Nuevo"
        </label>
    </div>

    <!-- Imágenes -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Imágenes</h2>

        @if($product->exists && $product->images->count())
        <div class="grid grid-cols-4 gap-3">
            @foreach($product->images as $image)
            <div class="relative">
                <img src="{{ $image->url }}" class="w-full aspect-square object-cover rounded-lg border border-gray-100">
                <label class="absolute top-1 right-1 bg-white/90 rounded-full p-1 text-red-600 text-xs">
                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"> ✕
                </label>
            </div>
            @endforeach
        </div>
        @endif

        <div>
            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">Subir nuevas imágenes</label>
            <input type="file" name="images[]" multiple accept="image/*" class="text-sm">
        </div>

        <div>
            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1.5">O agregar por URL (una por línea)</label>
            <textarea id="image_urls_raw" rows="2" placeholder="https://..." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm"></textarea>
            <div id="image_url_inputs"></div>
        </div>
    </div>

    <!-- Variantes -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Variantes (talla / color / stock)</h2>
            <button type="button" id="add_variant" class="text-xs font-semibold uppercase tracking-wider bg-gray-100 px-3 py-1.5 rounded-lg hover:bg-gray-200">+ Agregar variante</button>
        </div>

        <div id="variants_wrapper" class="space-y-3">
            @foreach(old('variants', $product->variants->toArray() ?? []) as $i => $variant)
            <div class="variant-row grid grid-cols-6 gap-2 items-center">
                <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $variant['id'] ?? '' }}">
                <input type="text" name="variants[{{ $i }}][sku]" placeholder="SKU" value="{{ $variant['sku'] ?? '' }}" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
                <input type="text" name="variants[{{ $i }}][size]" placeholder="Talla" value="{{ $variant['size'] ?? '' }}" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
                <input type="text" name="variants[{{ $i }}][color]" placeholder="Color" value="{{ $variant['color'] ?? '' }}" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
                <input type="text" name="variants[{{ $i }}][color_hex]" placeholder="#000000" value="{{ $variant['color_hex'] ?? '' }}" class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
                <input type="number" name="variants[{{ $i }}][stock]" placeholder="Stock" value="{{ $variant['stock'] ?? 0 }}" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
                <div class="flex gap-1">
                    <input type="number" step="0.01" name="variants[{{ $i }}][price]" placeholder="Precio (opcional)" value="{{ $variant['price'] ?? '' }}" class="border border-gray-200 rounded-lg px-3 py-2 text-xs flex-1">
                    <button type="button" class="remove-variant text-red-500 text-xs px-1">✕</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="bg-black text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-lg hover:bg-gray-800">
            Guardar producto
        </button>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-500 px-6 py-2.5">Cancelar</a>
    </div>
</form>

<template id="variant_row_template">
    <div class="variant-row grid grid-cols-6 gap-2 items-center">
        <input type="hidden" name="variants[__INDEX__][id]" value="">
        <input type="text" name="variants[__INDEX__][sku]" placeholder="SKU" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
        <input type="text" name="variants[__INDEX__][size]" placeholder="Talla" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
        <input type="text" name="variants[__INDEX__][color]" placeholder="Color" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
        <input type="text" name="variants[__INDEX__][color_hex]" placeholder="#000000" class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
        <input type="number" name="variants[__INDEX__][stock]" placeholder="Stock" required class="border border-gray-200 rounded-lg px-3 py-2 text-xs">
        <div class="flex gap-1">
            <input type="number" step="0.01" name="variants[__INDEX__][price]" placeholder="Precio (opcional)" class="border border-gray-200 rounded-lg px-3 py-2 text-xs flex-1">
            <button type="button" class="remove-variant text-red-500 text-xs px-1">✕</button>
        </div>
    </div>
</template>

<script>
    let variantIndex = {{ count(old('variants', $product->variants->toArray() ?? [])) }};
    const wrapper = document.getElementById('variants_wrapper');
    const template = document.getElementById('variant_row_template');

    document.getElementById('add_variant').addEventListener('click', () => {
        const html = template.innerHTML.replaceAll('__INDEX__', variantIndex++);
        const div = document.createElement('div');
        div.innerHTML = html.trim();
        wrapper.appendChild(div.firstElementChild);
    });

    wrapper.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-variant')) {
            e.target.closest('.variant-row').remove();
        }
    });

    // Convierte el textarea de URLs (una por línea) en inputs hidden image_urls[]
    document.querySelector('form').addEventListener('submit', () => {
        const raw = document.getElementById('image_urls_raw').value;
        const container = document.getElementById('image_url_inputs');
        container.innerHTML = '';
        raw.split('\n').map(u => u.trim()).filter(Boolean).forEach(url => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'image_urls[]';
            input.value = url;
            container.appendChild(input);
        });
    });
</script>
@endsection
