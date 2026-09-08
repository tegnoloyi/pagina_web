@extends('layouts.app')

@section('content')
<!-- BANNER HERO EDITORIAL -->
<section class="relative bg-black text-white h-[75vh] flex items-center justify-center overflow-hidden">
    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1600&auto=format&fit=crop&q=80" 
         class="absolute inset-0 w-full h-full object-cover opacity-60">
    <div class="relative z-10 text-center px-4 max-w-2xl">
        <span class="text-xs font-semibold tracking-widest uppercase text-gray-300">Colección 2026</span>
        <h1 class="text-4xl md:text-6xl font-light tracking-tight mt-2 mb-6">NUEVA TEMPORADA</h1>
        <a href="{{ route('shop.catalog') }}" 
           class="inline-block bg-white text-black font-medium text-sm uppercase tracking-wider px-8 py-3.5 rounded-lg hover:bg-gray-200 transition">
            Explorar Catálogo
        </a>
    </div>
</section>

<!-- CARRUSEL / GRID DE CATEGORÍAS -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-xl font-semibold uppercase tracking-wider mb-8 text-center">Categorías</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop.catalog', ['category' => $category->id]) }}" class="group block text-center">
            <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 mb-3 shadow-sm group-hover:shadow-md transition">
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
            <span class="text-sm font-medium text-gray-800 tracking-wide uppercase">{{ $category->name }}</span>
        </a>
        @endforeach
    </div>
</section>

<!-- GRID DE PRODUCTOS DESTACADOS -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl font-bold uppercase tracking-wider">Destacados</h2>
            <p class="text-xs text-gray-500 mt-1">Esenciales seleccionados para tu guardarropa.</p>
        </div>
        <a href="{{ route('shop.catalog') }}" class="text-xs font-semibold uppercase tracking-wider underline">Ver Todo</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($featuredProducts as $product)
        <div class="group relative flex flex-col">
            <!-- Imagen con Botón Flotante "+" -->
            <div class="aspect-[3/4] w-full rounded-lg overflow-hidden bg-gray-100 relative mb-4">
                @if($product->is_new)
                    <span class="absolute top-3 left-3 bg-black text-white text-[10px] font-bold px-2 py-1 uppercase rounded z-10">Nuevo</span>
                @endif
                
                @if($product->images->first())
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @endif

                <!-- Botón de Agregado Rápido: lleva a la ficha para elegir talla/color -->
                <a href="{{ route('shop.show', $product->id) }}" class="absolute bottom-3 right-3 bg-black text-white p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition duration-300 hover:scale-110">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </a>
            </div>

            <!-- Información -->
            <div class="flex-grow">
                <a href="{{ route('shop.show', $product->id) }}" class="text-sm font-medium text-gray-900 group-hover:underline block">
                    {{ $product->name }}
                </a>
                
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm font-semibold text-black">${{ number_format($product->base_price, 2) }}</span>
                    @if($product->old_price)
                        <span class="text-xs text-gray-400 line-through">${{ number_format($product->old_price, 2) }}</span>
                    @endif
                </div>

                <!-- Indicadores de Color (Swatches) -->
                <div class="flex items-center gap-1.5 mt-3">
                    @foreach($product->variants->unique('color') as $variant)
                        <span class="w-3.5 h-3.5 rounded-full border border-gray-300 shadow-sm" style="background-color: {{ $variant->color_hex ?? '#ccc' }};" title="{{ $variant->color }}"></span>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection