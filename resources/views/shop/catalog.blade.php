@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
    <div class="flex flex-col md:flex-row gap-6 md:gap-8">
        <!-- Filtros (Sidebar en Desktop / Scroll Horizontal en Mobile) -->
        <aside class="w-full md:w-72 flex-shrink-0">
            <div class="rounded-2xl md:rounded-[2rem] border border-[#eee9dd] bg-white p-4 md:p-6 shadow-sm">
                <span class="text-[10px] md:text-[11px] font-bold uppercase tracking-[0.24em] text-[#a66f57]">Colecciones</span>
                <h2 class="text-lg md:text-xl font-display font-bold uppercase tracking-[-0.01em] text-slate-900 mt-1 md:mt-3">Categorías</h2>
                
                <ul class="flex md:flex-col gap-2 overflow-x-auto pb-2 md:pb-0 mt-4 md:mt-6 no-scrollbar -mx-2 px-2 md:mx-0 md:px-0">
                    <li class="flex-shrink-0">
                        <a href="{{ route('shop.catalog') }}" 
                           class="inline-block md:block px-4 py-2 text-xs md:text-sm font-medium rounded-full transition-colors whitespace-nowrap {{ request('category') ? 'text-slate-700 hover:bg-[#f8f2ea] border border-transparent' : 'bg-[#384527] text-white shadow-sm' }}">
                            Todas
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li class="flex-shrink-0">
                        <a href="{{ route('shop.catalog', ['category' => $category->id]) }}"
                           class="inline-block md:block px-4 py-2 text-xs md:text-sm font-medium rounded-full transition-colors whitespace-nowrap {{ (string) request('category') === (string) $category->id ? 'bg-[#384527] text-white shadow-sm' : 'text-slate-700 hover:bg-[#f8f2ea] border border-transparent' }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Grid de productos -->
        <div class="flex-1">
            <!-- Header de Catálogo -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6 md:mb-8">
                <div>
                    <span class="text-[10px] md:text-[11px] font-bold uppercase tracking-[0.24em] text-[#a66f57]">Catálogo</span>
                    <h1 class="text-2xl md:text-4xl font-display font-bold uppercase tracking-[-0.02em] text-slate-900 mt-1">
                        Colección
                        @if(request('search'))
                            <span class="text-slate-500 font-normal normal-case block sm:inline text-base md:text-2xl">— resultados para "{{ request('search') }}"</span>
                        @endif
                    </h1>
                </div>
                <span class="rounded-full border border-[#d9d2c7] px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">
                    {{ $products->total() }} productos
                </span>
            </div>

            <!-- Listado de Productos -->
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-8">
                @forelse($products as $product)
                <a href="{{ route('shop.show', $product->id) }}" 
                   class="group block rounded-2xl md:rounded-[2rem] border border-[#ede8dd] bg-white p-2 md:p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    
                    <div class="aspect-[3/4] w-full rounded-xl md:rounded-[1.5rem] overflow-hidden bg-[#f7f3ee] relative">
                        @if($product->is_new)
                            <span class="absolute top-2 left-2 md:top-3 md:left-3 bg-[#384527] text-white text-[9px] md:text-[10px] font-black px-2.5 py-1 md:px-3 md:py-1.5 uppercase rounded-full z-10">
                                Nuevo
                            </span>
                        @endif
                        
                        @if($product->images->first())
                            <img src="{{ $product->images->first()->url }}" 
                                 alt="{{ $product->name }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>

                    <div class="px-1 md:px-2 pt-3 md:pt-4">
                        <h3 class="text-xs md:text-sm font-bold uppercase tracking-[0.05em] md:tracking-[0.1em] text-slate-900 group-hover:text-[#a66f57] line-clamp-1">
                            {{ $product->name }}
                        </h3>
                        <div class="mt-1 md:mt-2 flex items-center gap-1.5 md:gap-2 flex-wrap">
                            <span class="text-xs md:text-sm font-black text-slate-900">
                                ${{ number_format($product->base_price, 2) }}
                            </span>
                            @if($product->old_price)
                                <span class="text-[10px] md:text-xs text-slate-400 line-through">
                                    ${{ number_format($product->old_price, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center text-slate-500 py-12 md:py-16 rounded-2xl md:rounded-[2rem] border border-dashed border-[#cabda8] bg-[#fffaf7]">
                    <p class="text-sm md:text-base">No se encontraron productos.</p>
                </div>
                @endforelse
            </div>

            <!-- Paginación -->
            <div class="mt-8 md:mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection