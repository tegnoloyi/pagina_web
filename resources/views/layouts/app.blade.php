<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VESTIR — Tienda de Moda</title>
    <!-- Tailwind CSS por CDN para prototipado rápido -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F9FAFB] text-[#111827] antialiased flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Logo -->
            <a href="{{ route('shop.index') }}" class="text-2xl font-bold tracking-widest uppercase">VESTIR</a>

            <!-- Buscador Central -->
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <form action="{{ route('shop.catalog') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" placeholder="Buscar prendas, colecciones..." 
                        class="w-full bg-gray-100 text-sm rounded-full py-2 pl-4 pr-10 focus:outline-none focus:ring-1 focus:ring-black transition">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-black">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>

            <!-- Íconos de Usuario, Admin y Carrito -->
            <div class="flex items-center gap-5">
                @auth('customer')
                    <a href="{{ route('customer.orders.index') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-600 hover:text-black">
                        Mis pedidos
                    </a>
                @else
                    <a href="{{ route('customer.login') }}" class="text-xs font-semibold uppercase tracking-wider text-gray-600 hover:text-black">
                        Iniciar sesión
                    </a>
                @endauth

                <a href="{{ route('cart.index') }}" class="relative p-1 text-gray-700 hover:text-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    @if(app(\App\Services\CartService::class)->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-black text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ app(\App\Services\CartService::class)->count() }}</span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mt-6 bg-emerald-50 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- FOOTER MINIMALISTA -->
    <footer class="bg-white border-t border-gray-100 mt-20 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} VESTIR — Todos los derechos reservados. Estilo Lujo Minimalista.
        </div>
    </footer>

</body>
</html>