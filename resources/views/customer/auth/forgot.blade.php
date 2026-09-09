@extends('layouts.app')

@section('content')
<div class="max-w-sm mx-auto px-4 py-16">
    <h1 class="text-xl font-bold uppercase tracking-wider text-center mb-2">Recuperar cuenta</h1>
    <p class="text-sm text-gray-500 text-center mb-8">Te enviamos un enlace a tu correo para poner una contraseña nueva.</p>

    <form action="{{ route('customer.password.email') }}" method="POST" class="space-y-4">
        @csrf
        <input type="email" name="email" placeholder="Tu correo" required value="{{ old('email') }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <button type="submit" class="w-full bg-black text-white font-medium text-sm uppercase tracking-wider px-8 py-3 rounded-lg hover:bg-gray-800">
            Enviar enlace
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        <a href="{{ route('customer.login') }}" class="font-semibold text-black underline">Volver a iniciar sesión</a>
    </p>
</div>
@endsection
