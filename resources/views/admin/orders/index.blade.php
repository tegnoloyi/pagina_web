@extends('layouts.admin')

@section('content')
<h1 class="mb-8 text-2xl font-bold uppercase tracking-wider">Pedidos</h1>

<form method="GET" class="mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por # o cliente..."
           class="w-64 rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2 text-sm text-[var(--c-bone)] placeholder:text-[var(--c-bone-dim)]">
    <select name="status" class="rounded-lg border border-[var(--c-line)] bg-[var(--c-surface)] px-4 py-2 text-sm text-[var(--c-bone)]">
        <option value="">Todos los estatus</option>
        @foreach($statuses as $status)
            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <button class="rounded-lg bg-[var(--c-surface-2)] px-4 py-2 text-xs font-semibold uppercase tracking-wider text-[var(--c-bone)] hover:opacity-90">Filtrar</button>
</form>

<div class="overflow-hidden rounded-2xl border border-[var(--c-line)] bg-[var(--c-surface)]">
    <div class="overflow-x-auto">
    <table class="w-full min-w-[760px] text-left text-sm">
        <thead class="border-b border-[var(--c-line)] bg-[var(--c-surface-2)] text-xs font-semibold uppercase text-[var(--c-bone-dim)]">
            <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Cliente</th>
                <th class="px-6 py-3">Fecha</th>
                <th class="px-6 py-3">Pago</th>
                <th class="px-6 py-3">Estatus</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--c-line)]">
            @forelse($orders as $order)
            <tr class="hover:bg-[var(--c-surface-2)]/80">
                <td class="px-6 py-3 font-mono text-xs text-[var(--c-bone-dim)]">#{{ $order->id }}</td>
                <td class="px-6 py-3">
                    <p class="font-medium text-[var(--c-bone)]">{{ $order->customer_name }}</p>
                    <p class="text-xs text-[var(--c-bone-dim)]">{{ $order->customer_email }}</p>
                </td>
                <td class="px-6 py-3 text-xs text-[var(--c-bone-dim)]">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-3 text-xs">
                    <span class="rounded-full px-2 py-1 {{ $order->is_paid ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300' }}">
                        {{ $order->payment_method }} {{ $order->is_paid ? '· pagado' : '· pendiente' }}
                    </span>
                </td>
                <td class="px-6 py-3">
                    <span class="rounded-full bg-[var(--c-surface-2)] px-2.5 py-1 text-xs font-semibold uppercase text-[var(--c-bone)]">{{ $order->status }}</span>
                </td>
                <td class="px-6 py-3 font-semibold text-[var(--c-bone)]">${{ number_format($order->total, 2) }}</td>
                <td class="px-6 py-3 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-semibold uppercase text-[var(--c-bone-dim)] hover:text-[var(--c-bone)]">Ver</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-8 text-center text-[var(--c-bone-dim)]">No hay pedidos todavía.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<div class="mt-6 text-[var(--c-bone)]">{{ $orders->links() }}</div>
@endsection
