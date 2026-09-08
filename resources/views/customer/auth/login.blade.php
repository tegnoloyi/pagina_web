@extends('layouts.app')

@section('content')
<div class="max-w-sm mx-auto px-4 py-16">
    <h1 class="text-xl font-bold uppercase tracking-wider text-center mb-8">Iniciar sesión</h1>

    <form action="{{ route('customer.login') }}" method="POST" class="space-y-4">
        @csrf
        <input type="email" name="email" placeholder="Correo" required autofocus value="{{ old('email') }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <input type="password" name="password" placeholder="Contraseña" required
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <label class="flex items-center gap-2 text-xs text-gray-500">
            <input type="checkbox" name="remember"> Recordarme
        </label>
        <button type="submit" class="w-full bg-black text-white font-medium text-sm uppercase tracking-wider px-8 py-3 rounded-lg hover:bg-gray-800">
            Entrar
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        ¿No tienes cuenta? <a href="{{ route('customer.register') }}" class="font-semibold text-black underline">Regístrate</a>
    </p>
</div>
@endsection
