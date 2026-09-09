@extends('layouts.app')

@section('content')
<div class="max-w-sm mx-auto px-4 py-16">

    <a href="{{ route('customer.google.redirect') }}"
       class="w-full flex items-center justify-center gap-3 border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 mb-6">
        <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.64h6.47a5.53 5.53 0 01-2.4 3.63v3h3.87c2.27-2.09 3.58-5.17 3.58-8.82z"/><path fill="#34A853" d="M12 24c3.24 0 5.96-1.07 7.94-2.91l-3.87-3c-1.08.72-2.45 1.15-4.07 1.15-3.13 0-5.78-2.11-6.73-4.96H1.28v3.1A12 12 0 0012 24z"/><path fill="#FBBC05" d="M5.27 14.28A7.2 7.2 0 014.9 12c0-.79.14-1.56.37-2.28v-3.1H1.28A12 12 0 000 12c0 1.94.46 3.77 1.28 5.38l4-3.1z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.69 1.28 6.62l4 3.1C6.22 6.86 8.87 4.75 12 4.75z"/></svg>
        Continuar con Google
    </a>

    <div class="flex items-center gap-3 mb-6">
        <div class="h-px bg-gray-200 flex-1"></div>
        <span class="text-xs text-gray-400 uppercase">o</span>
        <div class="h-px bg-gray-200 flex-1"></div>
    </div>

    <!-- Pestañas -->
    <div class="flex mb-8 border border-gray-200 rounded-lg overflow-hidden text-sm font-semibold uppercase tracking-wider">
        <button type="button" id="tab_btn_login" onclick="showTab('login')" class="flex-1 py-2.5">Iniciar sesión</button>
        <button type="button" id="tab_btn_register" onclick="showTab('register')" class="flex-1 py-2.5">Crear cuenta</button>
    </div>

    <!-- LOGIN -->
    <div id="tab_login">
        <form action="{{ route('customer.login') }}" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Correo" required value="{{ old('email', $prefillEmail ?? '') }}"
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
        <p class="text-center text-sm text-gray-500 mt-4">
            <a href="{{ route('customer.password.request') }}" class="underline">¿Olvidaste tu contraseña?</a>
        </p>
    </div>

    <!-- REGISTRO -->
    <div id="tab_register" class="hidden">
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
    </div>
</div>

<script>
    function showTab(tab) {
        const isLogin = tab === 'login';
        document.getElementById('tab_login').classList.toggle('hidden', !isLogin);
        document.getElementById('tab_register').classList.toggle('hidden', isLogin);
        document.getElementById('tab_btn_login').classList.toggle('bg-black', isLogin);
        document.getElementById('tab_btn_login').classList.toggle('text-white', isLogin);
        document.getElementById('tab_btn_register').classList.toggle('bg-black', !isLogin);
        document.getElementById('tab_btn_register').classList.toggle('text-white', !isLogin);
    }

    // Abre la pestaña de registro si venimos de un error de registro o de ?tab=register
    const params = new URLSearchParams(window.location.search);
    const hasRegisterErrors = @json($errors->has('name') || $errors->has('password_confirmation'));
    showTab(params.get('tab') === 'register' || hasRegisterErrors ? 'register' : 'login');
</script>
@endsection
