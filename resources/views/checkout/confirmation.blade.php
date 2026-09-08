@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h1 class="text-2xl font-bold uppercase tracking-wider mb-2">¡Gracias por tu compra!</h1>
    <p class="text-gray-500 mb-8">Pedido #{{ $order->id }} —
        @if($order->is_paid)
            pagado.
        @else
            pendiente de confirmación de pago ({{ $order->payment_method }}).
        @endif
    </p>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-left mb-8">
        @foreach($order->items as $item)
        <div class="flex justify-between text-sm py-2 border-b border-gray-50 last:border-0">
            <span>{{ $item->variant->product->name }} ({{ $item->variant->size }}/{{ $item->variant->color }}) x{{ $item->qty }}</span>
            <span>${{ number_format($item->lineTotal(), 2) }}</span>
        </div>
        @endforeach
        <div class="flex justify-between text-base font-bold pt-4">
            <span>Total</span>
            <span>${{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <a href="{{ route('shop.catalog') }}" class="inline-block bg-black text-white text-sm font-medium uppercase tracking-wider px-8 py-3.5 rounded-lg hover:bg-gray-800">
        Seguir comprando
    </a>
</div>
@endsection
