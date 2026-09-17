@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" 
         x-data="{ 
             paymentMethod: 'mercadopago',
             subtotal: {{ $subtotal }},
             transferDiscountPercent: 10,
             get discount() {
                 return this.paymentMethod === 'transfer' ? (this.subtotal * (this.transferDiscountPercent / 100)) : 0;
             },
             get total() {
                 return this.subtotal - this.discount;
             }
         }">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-venom">Carrito</span>
            <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-[-0.02em] text-bone mt-2">
                Tu compra
            </h1>
        </div>
        <a href="{{ route('shop.catalog') }}" 
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full border border-white/10 bg-surface text-bone hover:text-venom hover:border-venom/30 transition text-[11px] font-bold uppercase tracking-[0.18em]">
            Continuar comprando
        </a>
    </div>

    @forelse($lines as $line)
        @if ($loop->first)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Lista de Productos --}}
                <div class="lg:col-span-7 xl:col-span-8 space-y-4">
        @endif

        @php
            $variant = $line['variant'];
            $product = $variant->product;
            $image   = $product->images->first();
        @endphp

        <article x-data="{ loading: false }" 
                 :class="{ 'opacity-50 pointer-events-none': loading }"
                 class="rounded-[2rem] border border-white/10 bg-surface p-4 md:p-6 transition-opacity duration-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                
                {{-- Detalle del Producto --}}
                <div class="flex items-center gap-4 min-w-0 flex-1">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-[1.25rem] bg-surface-2 overflow-hidden border border-white/10 shrink-0 flex items-center justify-center">
                        @if($image)
                            <img src="{{ $image->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
                        @else
                            <svg class="w-8 h-8 text-bone-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-black uppercase tracking-[0.22em] text-venom truncate">
                            {{ $product->category->name ?? 'Colección' }}
                        </p>
                        <h2 class="font-display text-xl font-black uppercase tracking-[-0.02em] text-bone mt-0.5 truncate">
                            {{ $product->name }}
                        </h2>
                        <div class="mt-1.5 text-xs text-bone-dim uppercase tracking-[0.12em] flex flex-wrap items-center gap-2">
                            <span>Talla: <strong class="text-bone font-semibold">{{ $variant->size }}</strong></span>
                            <span class="text-white/20">•</span>
                            <span>Color: <strong class="text-bone font-semibold">{{ $variant->color }}</strong></span>
                        </div>
                        <div class="mt-1.5 text-sm font-bold text-bone">
                            ${{ number_format($line['price'], 2) }}
                        </div>

                        @if(! $line['available'])
                            <div class="mt-2.5 inline-block rounded-xl border border-sting/70 bg-sting/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-sting">
                                Sin stock suficiente
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Controles de Cantidad y Eliminación --}}
                <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-4 border-t sm:border-t-0 border-white/5 pt-4 sm:pt-0">
                    
                    {{-- Actualizar Cantidad --}}
                    <form action="{{ route('cart.update') }}" method="POST" @submit="loading = true">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                        
                        <div class="flex items-center rounded-full border border-white/10 bg-ink p-1">
                            <button type="submit" 
                                    name="qty" 
                                    value="{{ max(0, $line['qty'] - 1) }}" 
                                    class="w-7 h-7 rounded-full flex items-center justify-center text-bone hover:bg-white/10 hover:text-venom transition font-bold text-sm">
                                −
                            </button>
                            <span class="px-2.5 text-xs font-black text-bone min-w-[32px] text-center">
                                {{ $line['qty'] }}
                            </span>
                            <button type="submit" 
                                    name="qty" 
                                    value="{{ $line['qty'] + 1 }}" 
                                    class="w-7 h-7 rounded-full flex items-center justify-center text-bone hover:bg-white/10 hover:text-venom transition font-bold text-sm">
                                +
                            </button>
                        </div>
                    </form>

                    {{-- Eliminar Item --}}
                    <form action="{{ route('cart.remove') }}" method="POST" @submit="loading = true">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                        <button type="submit" 
                                class="p-2 rounded-full border border-sting/40 text-sting hover:bg-sting hover:text-white transition"
                                title="Eliminar producto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>

                    {{-- Subtotal de Línea --}}
                    <div class="text-right min-w-[80px]">
                        <span class="block text-[9px] text-bone-dim font-black uppercase tracking-[0.14em]">Subtotal</span>
                        <span class="text-venom font-display text-lg sm:text-xl font-black">${{ number_format($line['line_total'], 2) }}</span>
                    </div>
                </div>

            </div>
        </article>

        @if ($loop->last)
                </div>

                {{-- Sidebar Resumen & Métodos de Pago --}}
                <aside class="lg:col-span-5 xl:col-span-4">
                    <form action="{{ route('checkout.show') }}" method="GET" class="rounded-[2rem] border border-white/10 bg-surface p-6 sticky top-10 space-y-6">
                        
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-[0.22em] text-venom">Resumen</span>
                            <h2 class="font-display text-2xl font-black uppercase tracking-[-0.02em] text-bone mt-1">Método de Pago</h2>
                        </div>

                        {{-- Seleccionador de Métodos de Pago --}}
                        <div class="space-y-3">
                            
                            {{-- Opción: Mercado Pago --}}
                            <label :class="{ 'border-venom/80 bg-venom/5 ring-1 ring-venom/50': paymentMethod === 'mercadopago', 'border-white/10 bg-surface-2 hover:border-white/20': paymentMethod !== 'mercadopago' }"
                                   class="relative flex flex-col p-4 rounded-2xl border cursor-pointer transition-all duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="mercadopago" x-model="paymentMethod" class="sr-only">
                                        <div class="w-4 h-4 rounded-full border flex items-center justify-center transition"
                                             :class="paymentMethod === 'mercadopago' ? 'border-venom bg-venom' : 'border-white/30'">
                                            <div class="w-1.5 h-1.5 rounded-full bg-ink" x-show="paymentMethod === 'mercadopago'"></div>
                                        </div>
                                        <span class="text-xs font-black uppercase tracking-[0.12em] text-bone">Mercado Pago</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md bg-[#009EE3]/10 text-[#009EE3] text-[9px] font-bold uppercase tracking-wider">
                                        Tarjetas / Efectivo
                                    </span>
                                </div>
                                <p class="text-[11px] text-bone-dim mt-2 pl-7">
                                    Paga con tarjeta de crédito, débito o saldo en cuenta Mercado Pago hasta en 12 cuotas.
                                </p>
                            </label>

                            {{-- Opción: Transferencia Bancaria --}}
                            <label :class="{ 'border-venom/80 bg-venom/5 ring-1 ring-venom/50': paymentMethod === 'transfer', 'border-white/10 bg-surface-2 hover:border-white/20': paymentMethod !== 'transfer' }"
                                   class="relative flex flex-col p-4 rounded-2xl border cursor-pointer transition-all duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="transfer" x-model="paymentMethod" class="sr-only">
                                        <div class="w-4 h-4 rounded-full border flex items-center justify-center transition"
                                             :class="paymentMethod === 'transfer' ? 'border-venom bg-venom' : 'border-white/30'">
                                            <div class="w-1.5 h-1.5 rounded-full bg-ink" x-show="paymentMethod === 'transfer'"></div>
                                        </div>
                                        <span class="text-xs font-black uppercase tracking-[0.12em] text-bone">Transferencia / SPEI</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md bg-venom/20 text-venom text-[9px] font-bold uppercase tracking-wider">
                                        10% OFF
                                    </span>
                                </div>
                                <p class="text-[11px] text-bone-dim mt-2 pl-7">
                                    Obtén un 10% de descuento abonando por transferencia directa o SPEI.
                                </p>
                            </label>

                        </div>

                        {{-- Desglose Financiero --}}
                        <div class="border-t border-white/10 pt-5 space-y-2.5">
                            <div class="flex items-center justify-between text-xs text-bone-dim uppercase tracking-[0.12em]">
                                <span>Subtotal</span>
                                <span class="font-bold text-bone">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            <div x-show="paymentMethod === 'transfer'" x-cloak 
                                 class="flex items-center justify-between text-xs text-venom uppercase tracking-[0.12em]">
                                <span>Descuento Transferencia (10%)</span>
                                <span class="font-bold">-$<span x-text="discount.toFixed(2)"></span></span>
                            </div>

                            <div class="border-t border-white/10 pt-3 flex items-center justify-between text-bone">
                                <span class="text-xs font-bold uppercase tracking-[0.12em]">Total</span>
                                <span class="font-display text-3xl font-black text-venom">
                                    $<span x-text="total.toFixed(2)"></span>
                                </span>
                            </div>
                        </div>

                        {{-- Botón de Acción Dinámico --}}
                        <button type="submit" 
                                @if($hasStockIssues) disabled @endif
                                class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-venom text-ink px-5 py-3.5 font-black uppercase tracking-[0.18em] text-[11px] transition hover:brightness-110 active:scale-[0.98] disabled:pointer-events-none disabled:opacity-50">
                            <span x-text="paymentMethod === 'mercadopago' ? 'Pagar con Mercado Pago' : 'Continuar transferencia'"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>

                        @if($hasStockIssues)
                            <p class="text-sting text-[10px] text-center font-bold uppercase tracking-[0.12em]">
                                Corrige el stock para seguir
                            </p>
                        @endif

                    </form>
                </aside>
            </div>
        @endif

    @empty
        {{-- Estado Carrito Vacío --}}
        <div class="rounded-[2rem] border border-white/10 bg-surface p-12 text-center max-w-2xl mx-auto">
            <div class="w-16 h-16 rounded-full bg-surface-2 border border-white/10 flex items-center justify-center mx-auto mb-4 text-venom">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h2 class="font-display text-3xl font-black uppercase tracking-[-0.01em] text-bone">Tu carrito está vacío</h2>
            <p class="text-bone-dim mt-2 text-sm">Aún no agregaste prendas a tu compra.</p>
            <a href="{{ route('shop.catalog') }}" 
               class="inline-flex mt-6 px-6 py-3 rounded-full bg-venom text-ink font-black uppercase tracking-[0.18em] text-[11px] hover:brightness-110 transition active:scale-[0.98]">
                Ver catálogo
            </a>
        </div>
    @endforelse
</section>
@endsection