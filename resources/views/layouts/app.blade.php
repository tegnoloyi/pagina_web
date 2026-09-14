<!DOCTYPE html>
<html lang="es" class="h-full scroll-smooth dark overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scorpio — Ropa urbana y de entrenamiento para hombre</title>

    <!-- Tema claro/oscuro: se aplica ANTES de pintar la página para que no haya parpadeo
         (un instante en oscuro y luego brinca a claro, o viceversa). Por defecto es oscuro
         si el visitante nunca ha tocado el switch. -->
    <script>
        (function () {
            var saved = localStorage.getItem('scorpio-theme');
            if (saved === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <!-- Google Fonts: Big Shoulders Display (títulos) & Inter (cuerpo) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800;900&family=Inter:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- CSS/JS compilados por Vite (Tailwind 4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ink text-bone antialiased flex flex-col min-h-full w-full max-w-full overflow-x-hidden font-sans selection:bg-venom selection:text-ink" x-data="{ mobileMenuOpen: false }">

    <!-- BANNER PROMOCIONAL -->
    <div class="bg-surface text-bone text-[10px] sm:text-[11px] font-semibold tracking-[0.2em] uppercase py-2.5 px-4 text-center border-b border-line">
        <div class="max-w-7xl mx-auto flex items-center justify-between sm:justify-center gap-4">
            <span class="truncate">ENVÍO GRATIS EN COMPRAS MAYORES A $999 MXN</span>
            <span class="hidden md:inline text-bone-dim">•</span>
            <span class="hidden md:inline text-bone-dim">GYM WEAR Y STREETWEAR PARA HOMBRE</span>
            <span class="hidden lg:inline text-bone-dim">•</span>
            <span class="hidden lg:inline text-venom font-bold">NUEVA COLECCIÓN DISPONIBLE</span>
        </div>
    </div>

    <!-- NAVBAR -->
    <header class="sticky top-0 z-40 bg-ink/95 backdrop-blur-md border-b border-line transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-6">

            <!-- Botón Menú Móvil -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden p-2 text-bone hover:text-venom focus:outline-none transition-colors" aria-label="Abrir menú">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            @php
                $isHome = request()->routeIs('shop.index') && request()->path() === '/';
                $isCatalog = request()->routeIs('shop.catalog') && !request()->has('category') && !request()->has('sale');
                $isNovedades = request()->routeIs('shop.novedades');
                $isOfertas = request()->routeIs('shop.ofertas');
            @endphp

            <!-- Enlaces Principales (Desktop) -->
            <nav class="hidden lg:flex items-center gap-10 text-[11px] font-bold uppercase tracking-[0.18em] text-bone-dim">
                <a href="{{ route('shop.index') }}" class="{{ $isHome ? 'text-venom py-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[1.5px] after:bg-venom' : 'hover:text-bone py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-venom hover:after:w-full after:transition-all' }}">Inicio</a>
                <a href="{{ route('shop.catalog') }}" class="{{ $isCatalog ? 'text-venom py-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[1.5px] after:bg-venom' : 'hover:text-bone py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-venom hover:after:w-full after:transition-all' }}">Catálogo</a>
                <a href="{{ route('shop.novedades') }}" class="{{ $isNovedades ? 'text-venom py-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[1.5px] after:bg-venom' : 'hover:text-bone py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-venom hover:after:w-full after:transition-all' }}">Novedades</a>
                <a href="{{ route('shop.ofertas') }}" class="{{ $isOfertas ? 'text-sting py-1 font-extrabold' : 'hover:text-bone py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-sting hover:after:w-full after:transition-all text-bone-dim' }}">Ofertas</a>
            </nav>

            <!-- Buscador Integrado -->
            <div class="hidden md:flex flex-1 max-w-xs mx-2">
                <form action="{{ route('shop.catalog') }}" method="GET" class="w-full relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="BUSCAR PRODUCTO..."
                        class="w-full bg-surface text-[11px] font-medium tracking-wider text-bone placeholder-bone-dim rounded-full py-2.5 pl-10 pr-4 focus:outline-none focus:bg-surface-2 focus:ring-1 focus:ring-venom border border-transparent focus:border-venom transition-all">
                    <svg class="w-4 h-4 text-bone-dim absolute left-3.5 top-3 group-focus-within:text-venom transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
            </div>

            <!-- Acciones / Usuario & Carrito -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Switch Claro/Oscuro -->
                <button
                    type="button"
                    @click="
                        document.documentElement.classList.toggle('dark');
                        localStorage.setItem('scorpio-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                    "
                    class="p-2.5 rounded-full bg-surface hover:bg-surface-2 text-bone transition-all"
                    aria-label="Cambiar entre modo claro y oscuro">
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>

                @auth('customer')
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 text-[11px] font-bold tracking-wider uppercase text-bone hover:text-venom bg-surface hover:bg-surface-2 px-3.5 py-2 rounded-full transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="hidden sm:inline">Mi Cuenta</span>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-52 bg-surface rounded-2xl shadow-2xl border border-line py-2 z-50 text-xs">
                            <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2.5 text-bone hover:bg-surface-2 hover:text-venom font-medium">Mis Pedidos</a>
                            <hr class="my-1 border-line">
                            <form method="POST" action="{{ route('customer.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sting hover:bg-surface-2 font-semibold">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('customer.login') }}" class="text-[11px] font-bold uppercase tracking-widest text-bone hover:text-venom transition px-2 py-1">
                        Iniciar Sesión
                    </a>
                @endauth

                <!-- Carrito -->
                <a href="{{ route('cart.index') }}" class="relative p-2.5 bg-venom text-ink rounded-full hover:brightness-110 transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    @if(app(\App\Services\CartService::class)->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-sting text-white text-[9px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-ink">
                            {{ app(\App\Services\CartService::class)->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Fondo oscuro al abrir el menú móvil -->
        <div x-show="mobileMenuOpen" x-cloak x-transition.opacity @click="mobileMenuOpen = false"
             class="lg:hidden fixed inset-0 top-0 bg-ink/70 backdrop-blur-sm z-30"></div>

        <!-- Menú Móvil Desplegable -->
        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden absolute left-0 right-0 top-full bg-surface border-b border-line rounded-b-3xl shadow-2xl z-30 px-5 pt-5 pb-6 space-y-5 max-h-[calc(100vh-5rem)] overflow-y-auto">

            <!-- Buscador -->
            <form action="{{ route('shop.catalog') }}" method="GET" class="w-full relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..."
                    class="w-full bg-surface-2 text-xs text-bone placeholder-bone-dim rounded-2xl py-3.5 pl-11 pr-4 focus:outline-none focus:ring-1 focus:ring-venom">
                <svg class="w-4 h-4 text-bone-dim absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </form>

            <!-- Cuenta -->
            @auth('customer')
                <div class="flex items-center gap-3 bg-surface-2 rounded-2xl p-3.5">
                    <div class="w-10 h-10 rounded-full bg-venom/15 text-venom flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('customer.orders.index') }}" class="block text-xs font-bold uppercase tracking-wider text-bone">Mis Pedidos</a>
                        <span class="block text-[10px] text-bone-dim mt-0.5">Ver historial de compras</span>
                    </div>
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <button type="submit" class="text-[10px] font-bold uppercase tracking-wider text-sting px-2 py-1">Salir</button>
                    </form>
                </div>
            @else
                <a href="{{ route('customer.login') }}"
                   class="flex items-center justify-center gap-2 w-full bg-venom text-ink font-bold text-xs uppercase tracking-widest py-3.5 rounded-2xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Iniciar Sesión
                </a>
            @endauth

            <!-- Enlaces Principales -->
            <div class="flex flex-col gap-1 text-xs font-bold uppercase tracking-widest">
                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-colors {{ $isHome ? 'bg-venom/10 text-venom' : 'text-bone-dim hover:bg-surface-2 hover:text-bone' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Inicio
                </a>
                <a href="{{ route('shop.catalog') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-colors {{ $isCatalog ? 'bg-venom/10 text-venom' : 'text-bone-dim hover:bg-surface-2 hover:text-bone' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Catálogo Completo
                </a>
                <a href="{{ route('shop.novedades') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-colors {{ $isNovedades ? 'bg-venom/10 text-venom' : 'text-bone-dim hover:bg-surface-2 hover:text-bone' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    Novedades
                </a>
                <a href="{{ route('shop.ofertas') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-colors {{ $isOfertas ? 'bg-sting/10 text-sting' : 'text-bone-dim hover:bg-surface-2 hover:text-bone' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5.586a1 1 0 01.707.293l7.414 7.414a1 1 0 010 1.414l-7.586 7.586a1 1 0 01-1.414 0L4.293 12.293A1 1 0 014 11.586V6a3 3 0 013-3z"/></svg>
                    Ofertas Especiales
                </a>
            </div>

            <!-- Switch modo claro/oscuro -->
            <button
                type="button"
                @click="
                    document.documentElement.classList.toggle('dark');
                    localStorage.setItem('scorpio-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                "
                class="w-full flex items-center justify-between gap-2 bg-surface-2 rounded-2xl px-4 py-3.5">
                <span class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-bone">
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <span class="dark:hidden">Modo claro</span>
                    <span class="hidden dark:inline">Modo oscuro</span>
                </span>
                <span class="relative inline-flex h-6 w-11 flex-shrink-0 items-center rounded-full bg-venom/20 dark:bg-venom transition-colors">
                    <span class="inline-block h-[18px] w-[18px] transform rounded-full bg-venom dark:bg-ink shadow transition-transform translate-x-1 dark:translate-x-[22px]"></span>
                </span>
            </button>
        </div>
    </header>

    <!-- MENSAJES FLASH Y ERRORES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" class="mt-6 bg-venom text-ink text-xs font-semibold px-5 py-3.5 rounded-2xl shadow-lg flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
                <button @click="show = false" type="button" class="text-ink/70 hover:text-ink">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" class="mt-6 bg-sting text-white text-xs font-medium px-5 py-4 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold">Por favor corrige los siguientes errores:</span>
                    <button @click="show = false" type="button" class="text-white/80 hover:text-white">&times;</button>
                </div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- BOTÓN FLOTANTE WHATSAPP CON TOOLTIP -->
    <div x-data="{ openTooltip: true }" class="fixed bottom-6 right-6 z-50 flex items-center gap-3">

        <div x-show="openTooltip"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4 scale-95"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             class="hidden sm:flex items-center gap-3 bg-surface text-bone px-4 py-3 rounded-2xl shadow-2xl border border-line relative">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
            </span>
            <div class="text-xs">
                <p class="font-bold text-bone">¿Necesitas ayuda?</p>
                <p class="text-[11px] text-bone-dim">Chatea con nosotros por WhatsApp</p>
            </div>
            <button @click="openTooltip = false" type="button" class="text-bone-dim hover:text-bone text-sm ml-1">&times;</button>
        </div>

        @php
            // Evaluación limpia para evitar exponer URLs locales (http://127.0.0.1...)
            if (request()->routeIs('customer.*')) {
                $mensajeWa = 'Hola, necesito ayuda con mi cuenta o información sobre mis pedidos en Scorpion.';
            } else {
                $mensajeWa = 'Hola, me gustaría recibir atención personalizada sobre los productos de Scorpion.';
            }
        @endphp

        <!-- BOTÓN FLOTANTE CON MENSAJE LIMPIO -->
        <a href="https://wa.me/525534742890?text={{ urlencode($mensajeWa) }}"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Contactar por WhatsApp"
           class="relative group bg-gradient-to-tr from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-green-400 text-white p-4 rounded-full shadow-2xl shadow-emerald-900/30 flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 ring-4 ring-emerald-500/20">

            <span class="absolute -z-10 inset-0 rounded-full bg-emerald-500/40 animate-ping opacity-75"></span>

            <svg class="w-7 h-7 fill-current drop-shadow-md transition-transform group-hover:rotate-6" viewBox="0 0 24 24">
                <path d="M12.011 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.332 5.001l-1.417 5.176 5.297-1.388c1.464.798 3.116 1.218 4.775 1.218h.004c5.506 0 9.989-4.478 9.99-9.984.001-2.668-1.034-5.176-2.919-7.062a9.913 9.913 0 00-7.061-2.945zm5.727 14.151c-.242.682-1.213 1.25-1.97 1.341-.52.062-1.196.113-3.488-.838-2.932-1.216-4.821-4.205-4.968-4.401-.146-.197-1.196-1.592-1.196-3.037 0-1.445.757-2.156 1.026-2.449.269-.293.586-.366.782-.366.196 0 .391.002.562.01.181.009.424-.069.664.507.245.587.83 2.028.903 2.175.073.147.122.318.024.513-.098.195-.147.317-.293.489-.147.172-.308.384-.44.516-.146.147-.298.308-.128.6.171.292.76 1.255 1.632 2.032 1.121.998 2.066 1.309 2.358 1.455.293.147.464.122.635-.073.171-.196.733-.855.928-1.148.195-.293.391-.244.659-.147.269.098 1.709.806 2.002.953.293.147.489.22.562.342.073.122.073.708-.169 1.39z"/>
            </svg>
        </a>
    </div>

</body>
</html>