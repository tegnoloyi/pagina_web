@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-xl font-bold uppercase tracking-wider">Mis pedidos</h1>
        <form method="POST" action="{{ route('customer.logout') }}">
            @csrf
            <button class="text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-black">Cerrar sesión</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 divide-y divide-gray-100">
        @forelse($orders as $order)
        <a href="{{ route('customer.orders.show', $order->id) }}" class="flex items-center justify-between p-5 hover:bg-gray-50">
            <div>
                <p class="text-sm font-medium">Pedido #{{ $order->id }}</p>
                <p class="text-xs text-gray-400">{{ $order->created_at->format('d/m/Y') }} — {{ ucfirst($order->status) }}</p>
            </div>
            <span class="text-sm font-semibold">${{ number_format($order->total, 2) }}</span>
        </a>
        @empty
        <p class="p-8 text-center text-gray-400">Aún no tienes pedidos.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</div>
@endsection
