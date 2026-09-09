@extends('layouts.app')

@section('content')
<div class="max-w-sm mx-auto px-4 py-16">
    <h1 class="text-xl font-bold uppercase tracking-wider text-center mb-8">Nueva contraseña</h1>

    <form action="{{ route('customer.password.update') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="email" name="email" placeholder="Correo" required value="{{ old('email', $email) }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <input type="password" name="password" placeholder="Nueva contraseña" required
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
        <button type="submit" class="w-full bg-black text-white font-medium text-sm uppercase tracking-wider px-8 py-3 rounded-lg hover:bg-gray-800">
            Guardar y entrar
        </button>
    </form>
</div>
@endsection
