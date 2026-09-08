@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('customer.orders.index') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-500">← Mis pedidos</a>
    <h1 class="text-xl font-bold uppercase tracking-wider mt-2 mb-1">Pedido #{{ $order->id }}</h1>
    <p class="text-sm text-gray-400 mb-8">Estatus: {{ ucfirst($order->status) }} · Pago: {{ $order->payment_method }} ({{ $order->is_paid ? 'pagado' : 'pendiente' }})</p>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
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

    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-sm text-gray-600">
        <p class="font-semibold text-gray-900 mb-1">Envío a:</p>
        <p>{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}, {{ $order->shipping_zip }}</p>
    </div>
</div>
@endsection
