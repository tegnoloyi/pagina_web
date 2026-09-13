@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-end justify-between gap-4 mb-8">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-venom">Carrito</span>
            <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-[-0.02em] text-bone mt-2">Tu compra</h1>
        </div>
        <a href="{{ route('shop.catalog') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/10 bg-surface text-bone hover:text-venom transition text-[11px] font-bold uppercase tracking-[0.18em]">
            Continuar comprando
        </a>
    </div>

    @if($lines->isEmpty())
        <div class="rounded-[2rem] border border-white/10 bg-surface p-8 text-center">
            <h2 class="font-display text-3xl font-black uppercase tracking-[-0.01em] text-bone">Tu carrito está vacío</h2>
            <p class="text-bone-dim mt-3">Aún no agregaste prendas a tu compra.</p>
            <a href="{{ route('shop.catalog') }}" class="inline-flex mt-6 px-5 py-3 rounded-full bg-venom text-ink font-bold uppercase tracking-[0.18em] text-[11px] hover:brightness-110 transition">
                Ver catálogo
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3 space-y-5">
                @foreach($lines as $line)
                    @php
                        $variant = $line['variant'];
                        $product = $variant->product;
                        $image = $product->images->first();
                    @endphp

                    <article class="rounded-[2rem] border border-white/10 bg-surface p-4 md:p-5">
                        <div class="flex flex-wrap gap-5 items-center">
                            <div class="w-24 h-24 rounded-[1.5rem] bg-surface-2 overflow-hidden border border-white/10 flex items-center justify-center">
                                @if($image)
                                    <img src="{{ $image->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-bone-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                            </div>

                            <div class="flex-1 min-w-[180px]">
                                <p class="text-[11px] font-black uppercase tracking-[0.22em] text-venom">{{ $product->category->name ?? 'Colección' }}</p>
                                <h2 class="font-display text-2xl font-black uppercase tracking-[-0.02em] text-bone mt-1">{{ $product->name }}</h2>
                                <div class="mt-2 text-xs text-bone-dim uppercase tracking-[0.12em]">
                                    <span>Talla {{ $variant->size }}</span>
                                    <span class="mx-2">•</span>
                                    <span>Color {{ $variant->color }}</span>
                                </div>
                                <div class="mt-2 text-sm font-bold text-bone">
                                    <span>${{ number_format($line['price'], 2) }}</span>
                                </div>

                                @if(! $line['available'])
                                    <div class="mt-3 rounded-xl border border-sting/70 bg-sting/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.14em] text-sting">
                                        Sin stock suficiente
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-3">
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                    <div class="flex items-center rounded-full border border-white/10 bg-ink">
                                        <button type="submit" name="qty" value="{{ max(0, $line['qty'] - 1) }}" class="px-3 py-2 text-bone hover:text-venom">−</button>
                                        <span class="px-3 py-2 text-xs font-black text-bone min-w-[46px] text-center">{{ $line['qty'] }}</span>
                                        <button type="submit" name="qty" value="{{ $line['qty'] + 1 }}" class="px-3 py-2 text-bone hover:text-venom">+</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                    <button type="submit" class="px-4 py-2 rounded-full border border-sting/60 text-sting hover:bg-sting hover:text-white font-bold uppercase tracking-[0.12em] text-[11px] transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>

                            <div class="text-right">
                                <span class="text-bone text-sm font-black uppercase tracking-[0.14em]">Subtotal</span>
                                <div class="text-venom font-display text-2xl font-black mt-1">${{ number_format($line['line_total'], 2) }}</div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <aside class="lg:col-span-1">
                <div class="rounded-[2rem] border border-white/10 bg-surface p-6 sticky top-10">
                    <span class="text-[11px] font-black uppercase tracking-[0.22em] text-venom">Resumen</span>
                    <div class="mt-6 border-t border-white/10 pt-5">
                        <div class="flex items-center justify-between text-bone">
                            <span class="text-xs font-bold uppercase tracking-[0.12em]">Subtotal</span>
                            <span class="font-display text-3xl font-black text-venom">${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout.show') }}" class="mt-6 w-full inline-flex items-center justify-center rounded-full bg-venom text-ink px-5 py-3 font-black uppercase tracking-[0.18em] text-[11px] transition hover:brightness-110 {{ $hasStockIssues ? 'pointer-events-none opacity-50' : '' }}">
                        Continuar al checkout
                    </a>
                    @if($hasStockIssues)
                        <p class="text-sting text-[11px] font-bold mt-3 uppercase tracking-[0.12em]">Corrige el stock para seguir</p>
                    @endif
                </div>
            </aside>
        </div>
    @endif
</section>
@endsection