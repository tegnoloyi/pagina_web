@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold uppercase tracking-wider mb-8">Pedidos</h1>

<form method="GET" class="flex gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por # o cliente..."
           class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-64">
    <select name="status" class="border border-gray-200 rounded-lg px-4 py-2 text-sm">
        <option value="">Todos los estatus</option>
        @foreach($statuses as $status)
            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <button class="text-xs font-semibold uppercase tracking-wider bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">Filtrar</button>
</form>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 uppercase text-gray-400 text-xs font-semibold border-b border-gray-100">
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
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50/50">
                <td class="px-6 py-3 font-mono text-xs text-gray-500">#{{ $order->id }}</td>
                <td class="px-6 py-3">
                    <p class="font-medium">{{ $order->customer_name }}</p>
                    <p class="text-xs text-gray-400">{{ $order->customer_email }}</p>
                </td>
                <td class="px-6 py-3 text-gray-500 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-3 text-xs">
                    <span class="px-2 py-1 rounded-full {{ $order->is_paid ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ $order->payment_method }} {{ $order->is_paid ? '· pagado' : '· pendiente' }}
                    </span>
                </td>
                <td class="px-6 py-3">
                    <span class="text-xs font-semibold uppercase px-2.5 py-1 rounded-full bg-gray-100 text-gray-700">{{ $order->status }}</span>
                </td>
                <td class="px-6 py-3 font-semibold">${{ number_format($order->total, 2) }}</td>
                <td class="px-6 py-3 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-semibold uppercase text-gray-600 hover:text-black">Ver</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">No hay pedidos todavía.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
