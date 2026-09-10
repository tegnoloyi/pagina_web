<!DOCTYPE html>
<html lang="es" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VESTIR - Tienda de Moda Minimalista</title>

    <!-- Google Fonts: Plus Jakarta Sans & Syne -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Syne:wght@500;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Syne', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f4f4f6',
                            100: '#e5e5eb',
                            900: '#0a0a0c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#faf9f6] text-slate-900 antialiased flex flex-col min-h-full font-sans selection:bg-black selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- BANNER PROMOCIONAL -->
    <div class="bg-[#384527] text-[#fffaf3] text-[10px] sm:text-[11px] font-semibold tracking-[0.2em] uppercase py-2.5 px-4 text-center border-b border-white/10">
        <div class="max-w-7xl mx-auto flex items-center justify-between sm:justify-center gap-4">
            <span class="truncate">ENVÍO GRATIS EN COMPRAS MAYORES A $999 MXN</span>
            <span class="hidden md:inline text-neutral-600">•</span>
            <span class="hidden md:inline text-neutral-300">HASTA 6 MESES SIN INTERESES</span>
            <span class="hidden lg:inline text-neutral-600">•</span>
            <span class="hidden lg:inline text-emerald-400 font-bold">NUEVO DROP DISPONIBLE</span>
        </div>
    </div>

    <!-- NAVBAR PREMIUM -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-6">
            
            <!-- Botón Menú Móvil -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden p-2 text-slate-800 hover:text-black focus:outline-none transition-colors" aria-label="Abrir menú">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('shop.index') }}" class="flex items-center gap-2 group">
                <span class="font-display text-2xl sm:text-3xl font-extrabold tracking-tighter text-black uppercase group-hover:opacity-80 transition-opacity duration-300">
                    VESTIR<span class="text-emerald-500">.</span>
                </span>
            </a>

            @php
                $isHome = request()->routeIs('shop.index') && request()->path() === '/';
                $isCatalog = request()->routeIs('shop.catalog') && !request()->has('category') && !request()->has('sale');
                $isNovedades = request()->routeIs('shop.catalog') && request()->query('category') === 'nueva-coleccion';
                $isOfertas = request()->routeIs('shop.catalog') && request()->query('sale') === 'true';
            @endphp

            <!-- Enlaces Principales (Desktop) -->
            <nav class="hidden lg:flex items-center gap-10 text-[11px] font-bold uppercase tracking-[0.18em] text-neutral-600">
                <a href="{{ route('shop.index') }}" class="{{ $isHome ? 'text-black py-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[1.5px] after:bg-black' : 'hover:text-black py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-black hover:after:w-full after:transition-all' }}">Inicio</a>
                <a href="{{ route('shop.catalog') }}" class="{{ $isCatalog ? 'text-black py-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[1.5px] after:bg-black' : 'hover:text-black py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-black hover:after:w-full after:transition-all' }}">Catálogo</a>
                <a href="{{ route('shop.catalog', ['category' => 'nueva-coleccion']) }}" class="{{ $isNovedades ? 'text-black py-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[1.5px] after:bg-black' : 'hover:text-black py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-black hover:after:w-full after:transition-all' }}">Novedades</a>
                <a href="{{ route('shop.catalog', ['sale' => 'true']) }}" class="{{ $isOfertas ? 'text-rose-600 py-1 font-extrabold' : 'hover:text-black py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-black hover:after:w-full after:transition-all text-neutral-600' }}">Ofertas</a>
            </nav>

            <!-- Buscador Integrado -->
            <div class="hidden md:flex flex-1 max-w-xs mx-2">
                <form action="{{ route('shop.catalog') }}" method="GET" class="w-full relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="BUSCAR PRODUCTO..." 
                        class="w-full bg-slate-100 text-[11px] font-medium tracking-wider text-slate-800 placeholder-slate-400 rounded-full py-2.5 pl-10 pr-4 focus:outline-none focus:bg-white focus:ring-1 focus:ring-black border border-transparent focus:border-black transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 group-focus-within:text-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
            </div>

            <!-- Acciones / Usuario & Carrito -->
            <div class="flex items-center gap-2 sm:gap-4">
                @auth('customer')
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 text-[11px] font-bold tracking-wider uppercase text-slate-800 hover:text-black bg-slate-100 hover:bg-slate-200/70 px-3.5 py-2 rounded-full transition">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="hidden sm:inline">Mi Cuenta</span>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50 text-xs">
                            <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-slate-50 hover:text-black font-medium">Mis Pedidos</a>
                            <hr class="my-1 border-slate-100">
                            <form method="POST" action="{{ route('customer.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-rose-600 hover:bg-rose-50 font-semibold">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('customer.login') }}" class="text-[11px] font-bold uppercase tracking-widest text-slate-900 hover:text-emerald-600 transition px-2 py-1">
                        Iniciar Sesión
                    </a>
                @endauth

                <!-- Carrito -->
                <a href="{{ route('cart.index') }}" class="relative p-2.5 bg-black text-white rounded-full hover:bg-slate-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    @if(app(\App\Services\CartService::class)->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-emerald-500 text-white text-[9px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white">
                            {{ app(\App\Services\CartService::class)->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Menú Móvil Desplegable -->
        <div x-show="mobileMenuOpen" x-cloak x-transition class="lg:hidden bg-white border-b border-slate-200 px-6 pt-3 pb-8 space-y-4">
            <form action="{{ route('shop.catalog') }}" method="GET" class="w-full relative my-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..." class="w-full bg-slate-100 text-xs rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-1 focus:ring-black">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </form>
            <div class="flex flex-col space-y-3 font-semibold uppercase text-xs tracking-widest text-slate-800">
                <a href="{{ route('shop.index') }}" class="py-2 border-b border-slate-100 {{ $isHome ? 'text-black font-extrabold' : '' }}">Inicio</a>
                <a href="{{ route('shop.catalog') }}" class="py-2 border-b border-slate-100 {{ $isCatalog ? 'text-black font-extrabold' : '' }}">Catálogo Completo</a>
                <a href="{{ route('shop.catalog', ['category' => 'nueva-coleccion']) }}" class="py-2 border-b border-slate-100 {{ $isNovedades ? 'text-black font-extrabold' : '' }}">Novedades</a>
                <a href="{{ route('shop.catalog', ['sale' => 'true']) }}" class="py-2 {{ $isOfertas ? 'text-rose-600 font-extrabold' : 'text-slate-800' }}">Ofertas Especiales</a>
            </div>
        </div>
    </header>

    <!-- MENSAJES FLASH Y ERRORES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" class="mt-6 bg-emerald-600 text-white text-xs font-semibold px-5 py-3.5 rounded-2xl shadow-lg shadow-emerald-600/10 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
                <button @click="show = false" type="button" class="text-white/80 hover:text-white">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" class="mt-6 bg-rose-600 text-white text-xs font-medium px-5 py-4 rounded-2xl shadow-lg shadow-rose-600/10">
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

    <!-- BLOQUE DE BENEFICIOS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 bg-white p-8 sm:p-10 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3.5 bg-slate-100 text-slate-900 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Envío Gratis</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">A todo México en compras +$999</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="p-3.5 bg-slate-100 text-slate-900 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Compra Segura</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Pagos 100% cifrados</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="p-3.5 bg-slate-100 text-slate-900 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Cambios Sin Costo</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">30 días de garantía</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="p-3.5 bg-slate-100 text-slate-900 rounded-2xl">
                    <svg class="w-6 h-6 text-emerald-600 fill-current" viewBox="0 0 24 24">
                        <path d="M12.011 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.332 5.001l-1.417 5.176 5.297-1.388c1.464.798 3.116 1.218 4.775 1.218h.004c5.506 0 9.989-4.478 9.99-9.984.001-2.668-1.034-5.176-2.919-7.062a9.913 9.913 0 00-7.061-2.945zm5.727 14.151c-.242.682-1.213 1.25-1.97 1.341-.52.062-1.196.113-3.488-.838-2.932-1.216-4.821-4.205-4.968-4.401-.146-.197-1.196-1.592-1.196-3.037 0-1.445.757-2.156 1.026-2.449.269-.293.586-.366.782-.366.196 0 .391.002.562.01.181.009.424-.069.664.507.245.587.83 2.028.903 2.175.073.147.122.318.024.513-.098.195-.147.317-.293.489-.147.172-.308.384-.44.516-.146.147-.298.308-.128.6.171.292.76 1.255 1.632 2.032 1.121.998 2.066 1.309 2.358 1.455.293.147.464.122.635-.073.171-.196.733-.855.928-1.148.195-.293.391-.244.659-.147.269.098 1.709.806 2.002.953.293.147.489.22.562.342.073.122.073.708-.169 1.39z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Atención WhatsApp</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Soporte directo e inmediato</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-black text-slate-400 mt-auto text-xs border-t border-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-10">
            
            <div class="space-y-4 md:col-span-1">
                <span class="font-display text-2xl font-black text-white uppercase tracking-tighter">VESTIR<span class="text-emerald-500">.</span></span>
                <p class="text-neutral-400 leading-relaxed text-[12px]">Redefiniendo el diseño y la moda contemporánea con prendas minimalistas y acabados de alta calidad.</p>
            </div>

            <div>
                <h4 class="text-white font-bold uppercase tracking-[0.15em] text-[11px] mb-4">Colección</h4>
                <ul class="space-y-3 text-[12px]">
                    <li><a href="{{ route('shop.catalog') }}" class="hover:text-white transition">Todas las prendas</a></li>
                    <li><a href="{{ route('shop.catalog', ['category' => 'nueva-coleccion']) }}" class="hover:text-white transition">Nueva Colección</a></li>
                    <li><a href="{{ route('shop.catalog', ['sale' => 'true']) }}" class="hover:text-white transition">Descuentos</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold uppercase tracking-[0.15em] text-[11px] mb-4">Ayuda</h4>
                <ul class="space-y-3 text-[12px]">
                    <li><a href="#" class="hover:text-white transition">Estado de mi pedido</a></li>
                    <li><a href="#" class="hover:text-white transition">Envíos y Devoluciones</a></li>
                    <li><a href="#" class="hover:text-white transition">Guía de tallas</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-emerald-400 font-bold uppercase tracking-[0.15em] text-[11px] mb-4">¿Quieres un sistema?</h4>
                <p class="text-neutral-400 leading-relaxed text-[12px] mb-4">
                    Desarrollamos e-commerce, tiendas web y software a la medida de tu marca.
                </p>
                <a href="https://wa.me/525534742890?text={{ urlencode('Hola, me interesa solicitar una cotización para el desarrollo de un sistema o tienda web.') }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-2.5 text-white font-semibold hover:bg-neutral-800 transition bg-neutral-900 px-4 py-2.5 rounded-xl border border-neutral-800 group">
                    <svg class="w-4 h-4 text-emerald-400 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                        <path d="M12.011 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.332 5.001l-1.417 5.176 5.297-1.388c1.464.798 3.116 1.218 4.775 1.218h.004c5.506 0 9.989-4.478 9.99-9.984.001-2.668-1.034-5.176-2.919-7.062a9.913 9.913 0 00-7.061-2.945zm5.727 14.151c-.242.682-1.213 1.25-1.97 1.341-.52.062-1.196.113-3.488-.838-2.932-1.216-4.821-4.205-4.968-4.401-.146-.197-1.196-1.592-1.196-3.037 0-1.445.757-2.156 1.026-2.449.269-.293.586-.366.782-.366.196 0 .391.002.562.01.181.009.424-.069.664.507.245.587.83 2.028.903 2.175.073.147.122.318.024.513-.098.195-.147.317-.293.489-.147.172-.308.384-.44.516-.146.147-.298.308-.128.6.171.292.76 1.255 1.632 2.032 1.121.998 2.066 1.309 2.358 1.455.293.147.464.122.635-.073.171-.196.733-.855.928-1.148.195-.293.391-.244.659-.147.269.098 1.709.806 2.002.953.293.147.489.22.562.342.073.122.073.708-.169 1.39z"/>
                    </svg>
                    <span>+52 5534742890</span>
                </a>
            </div>

            <div>
                <h4 class="text-white font-bold uppercase tracking-[0.15em] text-[11px] mb-4">Únete al club</h4>
                <p class="mb-3 text-neutral-400 text-[12px]">Recibe promociones y un 10% OFF en tu primera compra.</p>
                <form action="#" method="POST" class="flex gap-2">
                    @csrf
                    <input type="email" placeholder="Tu email..." required class="bg-neutral-900 text-white rounded-xl px-3.5 py-2.5 text-xs w-full focus:outline-none focus:ring-1 focus:ring-white border border-neutral-800">
                    <button type="submit" class="bg-white text-black font-bold px-4 py-2.5 rounded-xl hover:bg-neutral-200 transition text-[11px] uppercase tracking-wider">Unirme</button>
                </form>
            </div>

        </div>

        <div class="border-t border-neutral-900 py-6 text-center text-neutral-500 text-[11px] uppercase tracking-widest">
            &copy; {{ date('Y') }} VESTIR Inc. Todos los derechos reservados.
        </div>
    </footer>

    <!-- BOTÓN FLOTANTE WHATSAPP CON TOOLTIP -->
    <div x-data="{ openTooltip: true }" class="fixed bottom-6 right-6 z-50 flex items-center gap-3">
        
        <div x-show="openTooltip" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4 scale-95"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             class="hidden sm:flex items-center gap-3 bg-white text-slate-900 px-4 py-3 rounded-2xl shadow-2xl border border-slate-100 relative">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
            </span>
            <div class="text-xs">
                <p class="font-bold text-slate-900">¿Necesitas ayuda?</p>
                <p class="text-[11px] text-slate-500">Chatea con nosotros por WhatsApp</p>
            </div>
            <button @click="openTooltip = false" type="button" class="text-slate-400 hover:text-slate-600 text-sm ml-1">&times;</button>
        </div>

        @php
            // Evaluación limpia para evitar exponer URLs locales (http://127.0.0.1...)
            if (request()->routeIs('customer.*')) {
                $mensajeWa = 'Hola, necesito ayuda con mi cuenta o información sobre mis pedidos en VESTIR.';
            } else {
                $mensajeWa = 'Hola, me gustaría recibir atención personalizada sobre los productos de VESTIR.';
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