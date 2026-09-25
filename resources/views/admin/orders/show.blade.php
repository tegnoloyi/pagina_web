@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">← Pedidos</a>
<h1 class="mt-2 mb-8 text-2xl font-bold uppercase tracking-wider">Pedido #{{ $order->id }}</h1>

<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Artículos</h2>
            @foreach($order->items as $item)
            <div class="flex justify-between border-b border-[var(--c-line)] py-2 text-sm last:border-0">
                <span class="text-[var(--c-bone)]">{{ $item->variant->product->name ?? 'Producto eliminado' }} ({{ $item->variant->size ?? '-' }}/{{ $item->variant->color ?? '-' }}) x{{ $item->qty }}</span>
                <span class="text-[var(--c-bone)]">${{ number_format($item->lineTotal(), 2) }}</span>
            </div>
            @endforeach
            <div class="space-y-1 pt-4">
                <div class="flex justify-between text-sm text-[var(--c-bone-dim)]"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="flex justify-between text-sm text-[var(--c-bone-dim)]"><span>Envío</span><span>${{ number_format($order->shipping, 2) }}</span></div>
                <div class="flex justify-between text-base font-bold text-[var(--c-bone)]"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
            </div>
        </div>

        <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6 text-sm">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Cliente y envío</h2>
            <p><span class="text-[var(--c-bone-dim)]">Nombre:</span> <span class="text-[var(--c-bone)]">{{ $order->customer_name }}</span></p>
            <p><span class="text-[var(--c-bone-dim)]">Correo:</span> <span class="text-[var(--c-bone)]">{{ $order->customer_email }}</span></p>
            <p><span class="text-[var(--c-bone-dim)]">Teléfono:</span> <span class="text-[var(--c-bone)]">{{ $order->customer_phone ?? '—' }}</span></p>
            <p class="mt-3"><span class="text-[var(--c-bone-dim)]">Dirección:</span> <span class="text-[var(--c-bone)]">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}, {{ $order->shipping_zip }}</span></p>
            @if($order->notes)
                <p class="mt-3"><span class="text-[var(--c-bone-dim)]">Notas:</span> <span class="text-[var(--c-bone)]">{{ $order->notes }}</span></p>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Estatus</h2>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="w-full rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2.5 text-sm text-[var(--c-bone)]">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="w-full rounded-lg bg-[var(--c-venom)] px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition hover:brightness-110">
                    Actualizar estatus
                </button>
            </form>
        </div>

        <div class="rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)] p-6">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-[var(--c-bone-dim)]">Pago</h2>
            <p class="mb-4 text-sm text-[var(--c-bone)]">
                Método: <span class="font-medium">{{ $order->payment_method }}</span><br>
                Estado: <span class="font-medium {{ $order->is_paid ? 'text-emerald-600 dark:text-emerald-300' : 'text-amber-600 dark:text-amber-300' }}">{{ $order->is_paid ? 'Pagado' : 'Pendiente' }}</span>
                @if($order->paid_at)
                    <br><span class="text-xs text-[var(--c-bone-dim)]">{{ $order->paid_at->format('d/m/Y H:i') }}</span>
                @endif
            </p>
            @if(!$order->is_paid)
            <form action="{{ route('admin.orders.markPaid', $order) }}" method="POST">
                @csrf @method('PATCH')
                <button class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-emerald-700">
                    Marcar como pagado
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
