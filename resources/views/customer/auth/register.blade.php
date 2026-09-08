@extends('layouts.app')

@section('content')
<div class="max-w-sm mx-auto px-4 py-16">
    <h1 class="text-xl font-bold uppercase tracking-wider text-center mb-8">Crear cuenta</h1>

    <form action="{{ route('customer.register') }}" method="POST" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Nombre completo" required value="{{ old('name') }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <input type="email" name="email" placeholder="Correo" required value="{{ old('email') }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <input type="text" name="phone" placeholder="Teléfono (opcional)" value="{{ old('phone') }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <input type="password" name="password" placeholder="Contraseña" required
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <button type="submit" class="w-full bg-black text-white font-medium text-sm uppercase tracking-wider px-8 py-3 rounded-lg hover:bg-gray-800">
            Crear cuenta
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        ¿Ya tienes cuenta? <a href="{{ route('customer.login') }}" class="font-semibold text-black underline">Inicia sesión</a>
    </p>
</div>
@endsection
