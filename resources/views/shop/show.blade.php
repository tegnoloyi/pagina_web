@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Imágenes -->
        <div>
            <div class="aspect-[3/4] w-full rounded-2xl overflow-hidden bg-gray-100 mb-4">
                @if($product->images->first())
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-3">
                @foreach($product->images->skip(1) as $image)
                    <div class="aspect-square rounded-lg overflow-hidden bg-gray-100">
                        <img src="{{ $image->url }}" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Info y compra -->
        <div>
            <a href="{{ route('shop.catalog', ['category' => $product->category_id]) }}" class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                {{ $product->category->name }}
            </a>
            <h1 class="text-2xl font-bold mt-2 mb-4">{{ $product->name }}</h1>

            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl font-semibold">${{ number_format($product->base_price, 2) }}</span>
                @if($product->old_price)
                    <span class="text-sm text-gray-400 line-through">${{ number_format($product->old_price, 2) }}</span>
                @endif
            </div>

            @if($product->description)
                <p class="text-sm text-gray-600 mb-6">{{ $product->description }}</p>
            @endif

            @if($product->material)
                <p class="text-xs text-gray-400 mb-6">Material: {{ $product->material }}</p>
            @endif

            @if($product->variants->isEmpty())
                <p class="text-sm text-red-600 font-medium">No hay variantes disponibles por el momento.</p>
            @else
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-2">Talla / Color</label>
                        <select name="variant_id" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                            @foreach($product->variants as $variant)
                                <option value="{{ $variant->id }}" {{ $variant->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $variant->size }} — {{ $variant->color }}
                                    ({{ $variant->stock > 0 ? $variant->stock . ' disponibles' : 'agotado' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-2">Cantidad</label>
                        <input type="number" name="qty" value="1" min="1" max="20"
                               class="w-24 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    <button type="submit" class="w-full bg-black text-white font-medium text-sm uppercase tracking-wider px-8 py-3.5 rounded-lg hover:bg-gray-800 transition">
                        Agregar al carrito
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
