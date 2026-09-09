@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-xl font-bold uppercase tracking-wider mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <form action="{{ route('checkout.store') }}" method="POST" class="lg:col-span-2 space-y-8">
            @csrf

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Datos de contacto</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input type="text" name="customer_name" placeholder="Nombre completo" required
                           value="{{ old('customer_name', $customer->name ?? '') }}"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm sm:col-span-2">
                    <input type="email" name="customer_email" placeholder="Correo" required
                           value="{{ old('customer_email', $customer->email ?? '') }}"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                    <input type="text" name="customer_phone" placeholder="Teléfono"
                           value="{{ old('customer_phone', $customer->phone ?? '') }}"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                </div>
            </div>

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Envío</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input type="text" name="shipping_address" placeholder="Calle y número" required
                           value="{{ old('shipping_address') }}"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm sm:col-span-2">
                    <input type="text" name="shipping_city" placeholder="Ciudad" required
                           value="{{ old('shipping_city') }}"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                    <input type="text" name="shipping_state" placeholder="Estado" required
                           value="{{ old('shipping_state') }}"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                    <input type="text" name="shipping_zip" placeholder="Código postal" required
                           value="{{ old('shipping_zip') }}"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                </div>
            </div>

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Método de pago</h2>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 border border-gray-200 rounded-lg px-4 py-3 text-sm cursor-pointer has-[:checked]:border-black">
                        <input type="radio" name="payment_method" value="tarjeta" checked required> Tarjeta (simulado)
                    </label>
                    <label class="flex items-center gap-3 border border-gray-200 rounded-lg px-4 py-3 text-sm cursor-pointer has-[:checked]:border-black">
                        <input type="radio" name="payment_method" value="transferencia" required> Transferencia bancaria
                    </label>
                </div>
                <p class="text-xs text-gray-400 mt-2">Transferencia queda como "pendiente" hasta que el admin confirme el pago.</p>
            </div>

            @guest('customer')
            <div>
                <label class="flex items-center gap-2 text-sm mb-3">
                    <input type="checkbox" name="create_account" value="1" id="create_account" onchange="document.getElementById('pw_fields').classList.toggle('hidden')">
                    Crear una cuenta con estos datos para ver mis pedidos después
                </label>
                <div id="pw_fields" class="hidden grid grid-cols-2 gap-4">
                    <input type="password" name="password" placeholder="Contraseña"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                           class="border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                </div>
            </div>
            @endguest

            <textarea name="notes" placeholder="Notas del pedido (opcional)" rows="2"
                      class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">{{ old('notes') }}</textarea>

            <button type="submit" class="w-full bg-black text-white text-sm font-medium uppercase tracking-wider px-8 py-3.5 rounded-lg hover:bg-gray-800">
                Confirmar pedido
            </button>
        </form>

        <!-- Resumen -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 h-max">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Resumen</h2>
            <div class="space-y-3 mb-4">
                @foreach($lines as $line)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">{{ $line['variant']->product->name }} ({{ $line['variant']->size }}/{{ $line['variant']->color }}) x{{ $line['qty'] }}</span>
                    <span>${{ number_format($line['line_total'], 2) }}</span>
                </div>
                @endforeach
            </div>
            <div class="border-t border-gray-100 pt-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Envío</span>
                    <span>${{ number_format($shippingCost, 2) }}</span>
                </div>
                <div class="flex justify-between text-base font-bold pt-2">
                    <span>Total</span>
                    <span>${{ number_format($subtotal + $shippingCost, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
