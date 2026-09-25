@extends('layouts.admin')

@section('content')
<h1 class="mb-8 text-2xl font-bold uppercase tracking-wider">
    {{ $product->exists ? 'Editar producto' : 'Nuevo producto' }}
</h1>

<form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
      method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-8">
    @csrf
    @if($product->exists) @method('PUT') @endif

    <div class="space-y-4 rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Datos generales</h2>

        <div>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Categoría</label>
            <select name="category_id" required class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)]">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                   class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Descripción</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Material</label>
                <input type="text" name="material" value="{{ old('material', $product->material) }}"
                       class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Precio base</label>
                <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" required
                       class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Precio anterior</label>
                <input type="number" step="0.01" name="old_price" value="{{ old('old_price', $product->old_price) }}"
                       class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-[var(--c-bone)]">
            <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
            Marcar como "Nuevo"
        </label>
    </div>

    <div class="space-y-4 rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Imágenes</h2>

        @if($product->exists && $product->images->count())
        <div class="grid grid-cols-4 gap-3">
            @foreach($product->images as $image)
            <div class="relative">
                <img src="{{ $image->url }}" class="aspect-square w-full rounded-lg border border-[var(--c-line)] object-cover">
                <label class="absolute right-1 top-1 rounded-full bg-[var(--c-surface)]/90 p-1 text-xs text-red-600">
                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"> ✕
                </label>
            </div>
            @endforeach
        </div>
        @endif

        <div>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Subir nuevas imágenes</label>
            <input type="file" name="images[]" multiple accept="image/*" class="text-sm text-[var(--c-bone)]">
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">O agregar por URL (una por línea)</label>
            <textarea id="image_urls_raw" rows="2" placeholder="https://..." class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]"></textarea>
            <div id="image_url_inputs"></div>
        </div>
    </div>

    <div class="space-y-4 rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Variantes (talla / color / stock)</h2>
            <button type="button" id="add_variant" class="rounded-lg bg-[var(--c-surface-2)] px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-[var(--c-bone)] hover:opacity-90">+ Agregar variante</button>
        </div>

        <div id="variants_wrapper" class="space-y-3">
            @foreach(old('variants', $product->variants->toArray() ?? []) as $i => $variant)
            <div class="variant-row grid grid-cols-6 items-center gap-2">
                <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $variant['id'] ?? '' }}">
                <input type="text" name="variants[{{ $i }}][sku]" placeholder="SKU" value="{{ $variant['sku'] ?? '' }}" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
                <input type="text" name="variants[{{ $i }}][size]" placeholder="Talla" value="{{ $variant['size'] ?? '' }}" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
                <input type="text" name="variants[{{ $i }}][color]" placeholder="Color" value="{{ $variant['color'] ?? '' }}" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
                <input type="text" name="variants[{{ $i }}][color_hex]" placeholder="#000000" value="{{ $variant['color_hex'] ?? '' }}" class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
                <input type="number" name="variants[{{ $i }}][stock]" placeholder="Stock" value="{{ $variant['stock'] ?? 0 }}" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
                <div class="flex gap-1">
                    <input type="number" step="0.01" name="variants[{{ $i }}][price]" placeholder="Precio (opcional)" value="{{ $variant['price'] ?? '' }}" class="flex-1 rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
                    <button type="button" class="remove-variant px-1 text-xs text-red-500">✕</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="rounded-lg bg-[var(--c-venom)] px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition hover:brightness-110">
            Guardar producto
        </button>
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Cancelar</a>
    </div>
</form>

<template id="variant_row_template">
    <div class="variant-row grid grid-cols-6 items-center gap-2">
        <input type="hidden" name="variants[__INDEX__][id]" value="">
        <input type="text" name="variants[__INDEX__][sku]" placeholder="SKU" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
        <input type="text" name="variants[__INDEX__][size]" placeholder="Talla" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
        <input type="text" name="variants[__INDEX__][color]" placeholder="Color" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
        <input type="text" name="variants[__INDEX__][color_hex]" placeholder="#000000" class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
        <input type="number" name="variants[__INDEX__][stock]" placeholder="Stock" required class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
        <div class="flex gap-1">
            <input type="number" step="0.01" name="variants[__INDEX__][price]" placeholder="Precio (opcional)" class="flex-1 rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-3 py-2 text-xs text-[var(--c-bone)]">
            <button type="button" class="remove-variant px-1 text-xs text-red-500">✕</button>
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
