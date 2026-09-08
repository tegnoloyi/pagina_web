@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-500">← Pedidos</a>
<h1 class="text-2xl font-bold uppercase tracking-wider mt-2 mb-8">Pedido #{{ $order->id }}</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Artículos</h2>
            @foreach($order->items as $item)
            <div class="flex justify-between text-sm py-2 border-b border-gray-50 last:border-0">
                <span>{{ $item->variant->product->name ?? 'Producto eliminado' }} ({{ $item->variant->size ?? '-' }}/{{ $item->variant->color ?? '-' }}) x{{ $item->qty }}</span>
                <span>${{ number_format($item->lineTotal(), 2) }}</span>
            </div>
            @endforeach
            <div class="pt-4 space-y-1">
                <div class="flex justify-between text-sm text-gray-500"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="flex justify-between text-sm text-gray-500"><span>Envío</span><span>${{ number_format($order->shipping, 2) }}</span></div>
                <div class="flex justify-between text-base font-bold"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Cliente y envío</h2>
            <p><span class="text-gray-400">Nombre:</span> {{ $order->customer_name }}</p>
            <p><span class="text-gray-400">Correo:</span> {{ $order->customer_email }}</p>
            <p><span class="text-gray-400">Teléfono:</span> {{ $order->customer_phone ?? '—' }}</p>
            <p class="mt-3"><span class="text-gray-400">Dirección:</span> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}, {{ $order->shipping_zip }}</p>
            @if($order->notes)
                <p class="mt-3"><span class="text-gray-400">Notas:</span> {{ $order->notes }}</p>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Estatus</h2>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="w-full bg-black text-white text-xs font-semibold uppercase tracking-wider px-4 py-2.5 rounded-lg hover:bg-gray-800">
                    Actualizar estatus
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Pago</h2>
            <p class="text-sm mb-4">
                Método: <span class="font-medium">{{ $order->payment_method }}</span><br>
                Estado: <span class="font-medium {{ $order->is_paid ? 'text-emerald-600' : 'text-amber-600' }}">{{ $order->is_paid ? 'Pagado' : 'Pendiente' }}</span>
                @if($order->paid_at)
                    <br><span class="text-xs text-gray-400">{{ $order->paid_at->format('d/m/Y H:i') }}</span>
                @endif
            </p>
            @if(!$order->is_paid)
            <form action="{{ route('admin.orders.markPaid', $order) }}" method="POST">
                @csrf @method('PATCH')
                <button class="w-full bg-emerald-600 text-white text-xs font-semibold uppercase tracking-wider px-4 py-2.5 rounded-lg hover:bg-emerald-700">
                    Marcar como pagado
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
