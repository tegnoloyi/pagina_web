@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filtros -->
        <aside class="w-full md:w-56 flex-shrink-0">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Categorías</h2>
            <ul class="space-y-1 text-sm">
                <li>
                    <a href="{{ route('shop.catalog') }}" class="block px-3 py-1.5 rounded-lg {{ request('category') ? 'text-gray-600 hover:bg-gray-100' : 'bg-black text-white' }}">
                        Todas
                    </a>
                </li>
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('shop.catalog', ['category' => $category->id]) }}"
                       class="block px-3 py-1.5 rounded-lg {{ (string) request('category') === (string) $category->id ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $category->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </aside>

        <!-- Grid de productos -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-bold uppercase tracking-wider">
                    Catálogo
                    @if(request('search'))
                        <span class="text-gray-400 font-normal normal-case">— resultados para "{{ request('search') }}"</span>
                    @endif
                </h1>
                <span class="text-xs text-gray-400">{{ $products->total() }} productos</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                <a href="{{ route('shop.show', $product->id) }}" class="group block">
                    <div class="aspect-[3/4] w-full rounded-lg overflow-hidden bg-gray-100 relative mb-4">
                        @if($product->is_new)
                            <span class="absolute top-3 left-3 bg-black text-white text-[10px] font-bold px-2 py-1 uppercase rounded z-10">Nuevo</span>
                        @endif
                        @if($product->images->first())
                            <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @endif
                    </div>
                    <h3 class="text-sm font-medium text-gray-900">{{ $product->name }}</h3>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-sm font-semibold">${{ number_format($product->base_price, 2) }}</span>
                        @if($product->old_price)
                            <span class="text-xs text-gray-400 line-through">${{ number_format($product->old_price, 2) }}</span>
                        @endif
                    </div>
                </a>
                @empty
                <p class="col-span-full text-center text-gray-400 py-16">No se encontraron productos.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
