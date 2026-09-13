@extends('layouts.app')

@section('content')
<section class="relative overflow-x-hidden w-full max-w-full bg-ink">
    <div class="absolute left-0 top-0 h-full w-64 bg-venom/10 blur-3xl rounded-full -translate-x-1/2"></div>
    <div class="absolute right-0 top-12 h-80 w-80 bg-sting/10 blur-3xl rounded-full translate-x-1/3"></div>

    <!-- Hero -->
    <section class="relative min-h-[420px] md:min-h-[520px] flex items-center justify-center w-full max-w-full overflow-x-hidden px-4 sm:px-6 lg:px-8 py-16 text-center">
        <div class="max-w-3xl mx-auto w-full max-w-full px-4 sm:px-6 lg:px-8">
            <div class="w-full flex flex-col items-center">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-venom bg-surface/60 backdrop-blur">
                    <span class="w-2 h-2 rounded-full bg-venom"></span>
                    Colección 2026
                </div>

                <h1 class="mt-8 font-display text-5xl sm:text-6xl lg:text-8xl font-extrabold tracking-[-0.02em] leading-[0.92] text-bone uppercase">
                    Entrena.<br>
                    Sal a la calle.<br>
                    Repite.
                </h1>

                <p class="mt-6 text-sm md:text-base font-medium leading-7 text-bone-dim max-w-lg">
                    Ropa técnica y streetwear para hombres que se mueven todo el día. Del gym a la calle sin cambiarte.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 sm:gap-4 w-full sm:w-auto">
                    <a href="{{ route('shop.catalog') }}"
                       class="inline-flex items-center justify-center bg-venom text-ink font-bold text-[11px] uppercase tracking-[0.22em] px-5 py-3 sm:px-8 sm:py-3.5 rounded-full shadow-sm hover:brightness-110 transition-all duration-300 w-full sm:w-auto min-w-[170px]">
                        Explorar catálogo
                    </a>
                    <a href="{{ route('shop.catalog', ['sale' => 'true']) }}"
                       class="inline-flex items-center justify-center border border-sting text-sting font-bold text-[11px] uppercase tracking-[0.22em] px-5 py-3 sm:px-8 sm:py-3.5 rounded-full hover:bg-sting hover:text-white transition-all duration-300 w-full sm:w-auto min-w-[170px]">
                        Ver ofertas
                    </a>
                </div>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-3 sm:gap-8 text-[11px] font-bold uppercase tracking-[0.18em] text-bone-dim">
                    <span class="flex items-center gap-2"><span class="w-2 h-2 bg-venom rounded-full"></span>Gym Wear</span>
                    <span class="flex items-center gap-2"><span class="w-2 h-2 bg-sting rounded-full"></span>Streetwear</span>
                    <span class="flex items-center gap-2"><span class="w-2 h-2 bg-bone-dim rounded-full"></span>Edición 2026</span>
                </div>
            </div>
        </div>
    </section>
</section>

<!-- GRID DE CATEGORÍAS -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-wrap items-end justify-between gap-4 mb-9">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-[0.25em] text-venom">Colecciones</span>
            <h2 class="text-3xl md:text-4xl font-display font-bold uppercase tracking-[-0.02em] text-bone mt-3">Categorías</h2>
        </div>
        <a href="{{ route('shop.catalog') }}" class="text-[11px] font-bold uppercase tracking-[0.22em] text-bone-dim hover:text-venom transition">
            Ver todo
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop.catalog', ['category' => $category->id]) }}" class="group block">
            <div class="aspect-square rounded-[2rem] overflow-hidden bg-surface mb-4 border border-white/10 group-hover:-translate-y-1 group-hover:border-venom/40 transition-all duration-300 flex items-center justify-center">
                @if($category->image_url)
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <span class="font-display text-3xl font-black uppercase text-bone-dim group-hover:text-venom transition">
                        {{ mb_substr($category->name, 0, 1) }}
                    </span>
                @endif
            </div>
            <span class="block text-center text-[11px] font-bold tracking-[0.22em] uppercase text-bone-dim group-hover:text-venom transition">
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
            <span class="text-[11px] font-bold uppercase tracking-[0.25em] text-venom">Lo más nuevo</span>
            <h2 class="text-3xl md:text-4xl font-display font-bold uppercase tracking-[-0.02em] mt-3 text-bone">Destacados</h2>
        </div>
        <a href="{{ route('shop.catalog') }}" class="text-[11px] font-bold uppercase tracking-[0.22em] underline decoration-venom decoration-2 underline-offset-4 text-bone-dim hover:text-venom transition">
            Ver Todo
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($featuredProducts as $product)
        <article class="group relative flex flex-col rounded-[2rem] border border-white/10 bg-surface p-3 shadow-sm hover:shadow-lg hover:shadow-venom/5 hover:-translate-y-1 hover:border-venom/30 transition-all duration-300">
            <div class="aspect-[3/4] w-full rounded-[1.5rem] overflow-hidden bg-surface-2 relative">
                @if($product->is_new)
                    <span class="absolute top-3 left-3 bg-venom text-ink text-[10px] font-black px-3 py-1.5 uppercase rounded-full z-10">Nuevo</span>
                @endif

                @if($product->images->first())
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-bone-dim">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif

                <a href="{{ route('shop.show', $product->id) }}" class="absolute bottom-3 right-3 bg-venom text-ink p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition duration-300 hover:scale-110">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </a>
            </div>

            <div class="flex-grow px-2 py-5">
                <div class="flex items-start justify-between gap-3">
                    <a href="{{ route('shop.show', $product->id) }}" class="text-sm font-bold uppercase tracking-[0.08em] text-bone group-hover:text-venom block">
                        {{ $product->name }}
                    </a>
                </div>

                <div class="flex items-center gap-2 mt-3">
                    <span class="text-sm font-black text-bone">${{ number_format($product->base_price, 2) }}</span>
                    @if($product->old_price)
                        <span class="text-xs text-bone-dim line-through">${{ number_format($product->old_price, 2) }}</span>
                    @endif
                </div>

                <div class="flex items-center gap-1.5 mt-4">
                    @foreach($product->variants->unique('color') as $variant)
                        <span class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-sm" style="background-color: {{ $variant->color_hex ?? '#ccc' }};" title="{{ $variant->color }}"></span>
                    @endforeach
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endsection