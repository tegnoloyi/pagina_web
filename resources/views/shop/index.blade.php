@extends('layouts.app')

@section('content')
<section class="relative overflow-x-hidden w-full max-w-full bg-[#faf9f6]">
    <div class="absolute left-0 top-0 h-full w-64 bg-[#f3e7d8]/70 blur-3xl rounded-full -translate-x-1/2"></div>
    <div class="absolute right-0 top-12 h-80 w-80 bg-[#dde6d8]/80 blur-3xl rounded-full translate-x-1/3"></div>

    <!-- Hero editorial -->
    <section class="relative min-h-[420px] md:min-h-[560px] flex items-center w-full max-w-full overflow-x-hidden px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto w-full max-w-full px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-[1fr_0.9fr] gap-10 items-center">
            <div class="max-w-xl w-full">
                <div class="inline-flex items-center gap-2 rounded-full border border-[#9a9376] px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-[#65714d] bg-white/60 backdrop-blur">
                    <span class="w-2 h-2 rounded-full bg-[#a66f57]"></span>
                    Colección 2026
                </div>

                <h1 class="mt-8 font-display text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-[-0.04em] leading-tight sm:leading-snug lg:leading-none tracking-tight text-slate-900">
                    Nueva<br>
                    Temporada
                </h1>

                <p class="mt-6 text-sm md:text-base font-medium leading-7 text-slate-600 max-w-lg">
                    Prendas con movimiento, texturas cálidas y una paleta discreta para vestir de forma consciente.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 w-full sm:w-auto">
                    <a href="{{ route('shop.catalog') }}"
                       class="inline-flex items-center justify-center bg-[#384527] text-white font-bold text-[11px] uppercase tracking-[0.22em] px-5 py-3 sm:px-8 sm:py-3.5 rounded-full shadow-sm hover:bg-[#51633a] transition-all duration-300 w-full sm:w-auto min-w-[170px]">
                        Explorar catálogo
                    </a>
                    <a href="{{ route('shop.catalog', ['sale' => 'true']) }}"
                       class="inline-flex items-center justify-center border border-[#a66f57] text-[#a66f57] font-bold text-[11px] uppercase tracking-[0.22em] px-5 py-3 sm:px-8 sm:py-3.5 rounded-full hover:bg-[#a66f57] hover:text-white transition-all duration-300 w-full sm:w-auto min-w-[170px]">
                        Ver ofertas
                    </a>
                </div>

                <div class="mt-10 flex flex-wrap items-center gap-3 sm:gap-8 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    <span class="flex items-center gap-2"><span class="w-2 h-2 bg-[#a66f57] rounded-full"></span>Lookbook</span>
                    <span class="flex items-center gap-2"><span class="w-2 h-2 bg-[#6f8756] rounded-full"></span>Materiales</span>
                    <span class="flex items-center gap-2"><span class="w-2 h-2 bg-[#d3b98f] rounded-full"></span>Edición 2026</span>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -right-4 -top-4 w-32 h-32 border border-[#9a9376]/50 rounded-full"></div>
                <div class="relative aspect-[4/5] rounded-[2rem] overflow-hidden bg-white shadow-xl shadow-slate-200">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1600&auto=format&fit=crop&q=80"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <div class="absolute left-6 bottom-6 right-6 flex items-end justify-between">
                        <div class="text-white">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em]">Capsule 01</p>
                            <p class="mt-2 font-display text-3xl font-bold">Soft Forms</p>
                        </div>
                        <span class="rounded-full border border-white/80 px-4 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white">
                            2026
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<!-- CARRUSEL / GRID DE CATEGORÍAS -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-wrap items-end justify-between gap-4 mb-9">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-[0.25em] text-[#a66f57]">Colecciones</span>
            <h2 class="text-3xl md:text-4xl font-display font-bold uppercase tracking-[-0.02em] text-slate-900 mt-3">Categorías</h2>
        </div>
        <a href="{{ route('shop.catalog') }}" class="text-[11px] font-bold uppercase tracking-[0.22em] text-slate-700 hover:text-[#a66f57] transition">
            Ver todo
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop.catalog', ['category' => $category->id]) }}" class="group block">
            <div class="aspect-square rounded-[2rem] overflow-hidden bg-[#f7f3ee] mb-4 shadow-sm border border-white group-hover:-translate-y-1 group-hover:shadow-lg transition-all duration-300">
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
            <span class="block text-center text-[11px] font-bold tracking-[0.22em] uppercase text-slate-700 group-hover:text-[#a66f57] transition">
                {{ $category->name }}
            </span>
        </a>
        @endforeach
    </div>
</section>

<!-- GRID DE PRODUCTOS DESTACADOS -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="flex flex-wrap justify-between items-end mb-8 gap-4">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-[0.25em] text-[#a66f57]">Archivo editorial</span>
            <h2 class="text-3xl md:text-4xl font-display font-bold uppercase tracking-[-0.02em] mt-3 text-slate-900">Destacados</h2>
        </div>
        <a href="{{ route('shop.catalog') }}" class="text-[11px] font-bold uppercase tracking-[0.22em] underline decoration-[#a66f57] decoration-2 underline-offset-4 text-slate-700 hover:text-[#a66f57] transition">
            Ver Todo
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($featuredProducts as $product)
        <article class="group relative flex flex-col rounded-[2rem] border border-[#ece6dd] bg-white p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="aspect-[3/4] w-full rounded-[1.5rem] overflow-hidden bg-[#f7f3ee] relative">
                @if($product->is_new)
                    <span class="absolute top-3 left-3 bg-[#384527] text-white text-[10px] font-black px-3 py-1.5 uppercase rounded-full z-10">Nuevo</span>
                @endif

                @if($product->images->first())
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @endif

                <a href="{{ route('shop.show', $product->id) }}" class="absolute bottom-3 right-3 bg-white text-slate-900 p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition duration-300 hover:scale-110">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </a>
            </div>

            <div class="flex-grow px-2 py-5">
                <div class="flex items-start justify-between gap-3">
                    <a href="{{ route('shop.show', $product->id) }}" class="text-sm font-bold uppercase tracking-[0.08em] text-slate-900 group-hover:text-[#a66f57] block">
                        {{ $product->name }}
                    </a>
                </div>

                <div class="flex items-center gap-2 mt-3">
                    <span class="text-sm font-black text-slate-900">${{ number_format($product->base_price, 2) }}</span>
                    @if($product->old_price)
                        <span class="text-xs text-slate-400 line-through">${{ number_format($product->old_price, 2) }}</span>
                    @endif
                </div>

                <div class="flex items-center gap-1.5 mt-4">
                    @foreach($product->variants->unique('color') as $variant)
                        <span class="w-3.5 h-3.5 rounded-full border border-slate-200 shadow-sm" style="background-color: {{ $variant->color_hex ?? '#ccc' }};" title="{{ $variant->color }}"></span>
                    @endforeach
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endsection