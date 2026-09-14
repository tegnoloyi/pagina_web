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
                    <a href="{{ route('shop.ofertas') }}"
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

<!-- BLOQUE DE BENEFICIOS -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 mb-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 bg-surface p-8 sm:p-10 rounded-3xl border border-line">
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-surface-2 text-venom rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-bone">Envío Gratis</h4>
                <p class="text-[11px] text-bone-dim mt-0.5">A todo México en compras +$999</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-surface-2 text-venom rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-bone">Compra Segura</h4>
                <p class="text-[11px] text-bone-dim mt-0.5">Pagos 100% cifrados</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-surface-2 text-venom rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-bone">Cambios Sin Costo</h4>
                <p class="text-[11px] text-bone-dim mt-0.5">30 días de garantía</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-surface-2 text-venom rounded-2xl">
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path d="M12.011 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.332 5.001l-1.417 5.176 5.297-1.388c1.464.798 3.116 1.218 4.775 1.218h.004c5.506 0 9.989-4.478 9.99-9.984.001-2.668-1.034-5.176-2.919-7.062a9.913 9.913 0 00-7.061-2.945zm5.727 14.151c-.242.682-1.213 1.25-1.97 1.341-.52.062-1.196.113-3.488-.838-2.932-1.216-4.821-4.205-4.968-4.401-.146-.197-1.196-1.592-1.196-3.037 0-1.445.757-2.156 1.026-2.449.269-.293.586-.366.782-.366.196 0 .391.002.562.01.181.009.424-.069.664.507.245.587.83 2.028.903 2.175.073.147.122.318.024.513-.098.195-.147.317-.293.489-.147.172-.308.384-.44.516-.146.147-.298.308-.128.6.171.292.76 1.255 1.632 2.032 1.121.998 2.066 1.309 2.358 1.455.293.147.464.122.635-.073.171-.196.733-.855.928-1.148.195-.293.391-.244.659-.147.269.098 1.709.806 2.002.953.293.147.489.22.562.342.073.122.073.708-.169 1.39z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-bone">Atención WhatsApp</h4>
                <p class="text-[11px] text-bone-dim mt-0.5">Soporte directo e inmediato</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER: fijo en paleta oscura sin importar el tema activo -->
<footer class="dark bg-black text-bone-dim mt-auto text-xs border-t border-line">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-10">
        <div class="space-y-4 md:col-span-1">
            <p class="text-bone-dim leading-relaxed text-[12px]">Ropa urbana y de entrenamiento para hombres que no se detienen. Streetwear, gym wear y básicos con actitud.</p>
        </div>

        <div>
            <h4 class="text-bone font-bold uppercase tracking-[0.15em] text-[11px] mb-4">Colección</h4>
            <ul class="space-y-3 text-[12px]">
                <li><a href="{{ route('shop.catalog') }}" class="hover:text-venom transition">Todas las prendas</a></li>
                <li><a href="{{ route('shop.novedades') }}" class="hover:text-venom transition">Nueva Colección</a></li>
                <li><a href="{{ route('shop.ofertas') }}" class="hover:text-venom transition">Descuentos</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-bone font-bold uppercase tracking-[0.15em] text-[11px] mb-4">Ayuda</h4>
            <ul class="space-y-3 text-[12px]">
                <li><a href="#" class="hover:text-venom transition">Estado de mi pedido</a></li>
                <li><a href="#" class="hover:text-venom transition">Envíos y Devoluciones</a></li>
                <li><a href="#" class="hover:text-venom transition">Guía de tallas</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-venom font-bold uppercase tracking-[0.15em] text-[11px] mb-4">¿Quieres un sistema?</h4>
            <p class="text-bone-dim leading-relaxed text-[12px] mb-4">
                Desarrollamos e-commerce, tiendas web y software a la medida de tu marca.
            </p>
            <a href="https://wa.me/525534742890?text={{ urlencode('Hola, me interesa solicitar una cotización para el desarrollo de un sistema o tienda web.') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-2.5 text-bone font-semibold hover:bg-surface-2 transition bg-surface px-4 py-2.5 rounded-xl border border-line group">
                <svg class="w-4 h-4 text-venom fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                    <path d="M12.011 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.332 5.001l-1.417 5.176 5.297-1.388c1.464.798 3.116 1.218 4.775 1.218h.004c5.506 0 9.989-4.478 9.99-9.984.001-2.668-1.034-5.176-2.919-7.062a9.913 9.913 0 00-7.061-2.945zm5.727 14.151c-.242.682-1.213 1.25-1.97 1.341-.52.062-1.196.113-3.488-.838-2.932-1.216-4.821-4.205-4.968-4.401-.146-.197-1.196-1.592-1.196-3.037 0-1.445.757-2.156 1.026-2.449.269-.293.586-.366.782-.366.196 0 .391.002.562.01.181.009.424-.069.664.507.245.587.83 2.028.903 2.175.073.147.122.318.024.513-.098.195-.147.317-.293.489-.147.172-.308.384-.44.516-.146.147-.298.308-.128.6.171.292.76 1.255 1.632 2.032 1.121.998 2.066 1.309 2.358 1.455.293.147.464.122.635-.073.171-.196.733-.855.928-1.148.195-.293.391-.244.659-.147.269.098 1.709.806 2.002.953.293.147.489.22.562.342.073.122.073.708-.169 1.39z"/>
                </svg>
                <span>+52 5534742890</span>
            </a>
        </div>

        <div>
            <h4 class="text-bone font-bold uppercase tracking-[0.15em] text-[11px] mb-4">Únete al club</h4>
            <p class="mb-3 text-bone-dim text-[12px]">Recibe promociones y un 10% OFF en tu primera compra.</p>
            <form action="#" method="POST" class="flex gap-2">
                @csrf
                <input type="email" placeholder="Tu email..." required class="bg-surface text-bone rounded-xl px-3.5 py-2.5 text-xs w-full focus:outline-none focus:ring-1 focus:ring-venom border border-line">
                <button type="submit" class="bg-venom text-ink font-bold px-4 py-2.5 rounded-xl hover:brightness-110 transition text-[11px] uppercase tracking-wider">Unirme</button>
            </form>
        </div>
    </div>

    <div class="border-t border-line py-6 text-center text-bone-dim text-[11px] uppercase tracking-widest">
        &copy; {{ date('Y') }} Scorpio Inc. Todos los derechos reservados.
    </div>
</footer>
@endsection