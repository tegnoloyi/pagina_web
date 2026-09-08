@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-xl font-bold uppercase tracking-wider mb-8">Tu carrito</h1>

    @if($lines->isEmpty())
        <p class="text-gray-500 mb-6">Tu carrito está vacío.</p>
        <a href="{{ route('shop.catalog') }}" class="inline-block bg-black text-white text-sm font-medium uppercase tracking-wider px-6 py-3 rounded-lg hover:bg-gray-800">
            Ir al catálogo
        </a>
    @else
        <div class="bg-white rounded-2xl border border-gray-100 divide-y divide-gray-100 mb-8">
            @foreach($lines as $line)
            <div class="flex items-center gap-4 p-5">
                <div class="w-16 h-20 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($line['variant']->product->images->first())
                        <img src="{{ $line['variant']->product->images->first()->url }}" class="w-full h-full object-cover">
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $line['variant']->product->name }}</p>
                    <p class="text-xs text-gray-400">{{ $line['variant']->size }} — {{ $line['variant']->color }}</p>
                    @if(!$line['available'])
                        <p class="text-xs text-red-600 font-medium mt-1">Ya no hay stock suficiente, ajusta la cantidad.</p>
                    @endif
                </div>

                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="variant_id" value="{{ $line['variant']->id }}">
                    <input type="number" name="qty" value="{{ $line['qty'] }}" min="0" max="50"
                           class="w-16 border border-gray-200 rounded-lg px-2 py-1.5 text-sm text-center">
                    <button type="submit" class="text-xs font-semibold uppercase text-gray-500 hover:text-black">Actualizar</button>
                </form>

                <span class="text-sm font-semibold w-20 text-right">${{ number_format($line['line_total'], 2) }}</span>

                <form action="{{ route('cart.remove') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="variant_id" value="{{ $line['variant']->id }}">
                    <button type="submit" class="text-gray-400 hover:text-red-600" title="Eliminar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center mb-8">
            <span class="text-sm text-gray-500">Subtotal</span>
            <span class="text-xl font-bold">${{ number_format($subtotal, 2) }}</span>
        </div>

        <a href="{{ route('checkout.show') }}" class="block text-center bg-black text-white text-sm font-medium uppercase tracking-wider px-6 py-3.5 rounded-lg hover:bg-gray-800">
            Continuar a checkout
        </a>
    @endif
</div>
@endsection
