<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — VESTIR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#F9FAFB] text-[#111827] antialiased">
    <div class="flex min-h-screen">
        <!-- OVERLAY (solo móvil, detrás del sidebar cuando está abierto) -->
        <div id="sidebar_overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

        <!-- SIDEBAR: off-canvas en móvil, fija en lg+ -->
        <aside id="sidebar"
               class="w-64 bg-black text-white flex-shrink-0 flex flex-col fixed inset-y-0 left-0 z-40 -translate-x-full transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:w-60">
            <div class="h-16 flex items-center justify-between px-6 text-lg font-bold tracking-widest uppercase border-b border-white/10">
                <span>VESTIR <span class="text-[10px] font-normal tracking-normal normal-case text-gray-400 ml-1">admin</span></span>
                <button id="sidebar_close" class="lg:hidden text-gray-400 hover:text-white" aria-label="Cerrar menú">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="flex-1 px-3 py-6 space-y-1 text-sm overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white text-black font-semibold' : 'text-gray-300 hover:bg-white/10' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-white text-black font-semibold' : 'text-gray-300 hover:bg-white/10' }}">Productos</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-white text-black font-semibold' : 'text-gray-300 hover:bg-white/10' }}">Categorías</a>
                <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-white text-black font-semibold' : 'text-gray-300 hover:bg-white/10' }}">Pedidos</a>
            </nav>
            <div class="p-3 border-t border-white/10">
                <a href="{{ route('shop.index') }}" class="block px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10 text-xs uppercase tracking-wider">← Ver tienda</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10 text-xs uppercase tracking-wider">Cerrar sesión</button>
                </form>
            </div>
        </aside>

        <!-- CONTENIDO -->
        <div class="flex-1 min-w-0">
            <!-- BARRA SUPERIOR MÓVIL -->
            <div class="lg:hidden sticky top-0 z-20 h-14 bg-black text-white flex items-center px-4 gap-3">
                <button id="sidebar_open" class="text-white" aria-label="Abrir menú">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-sm font-bold tracking-widest uppercase">VESTIR <span class="text-[10px] font-normal tracking-normal normal-case text-gray-400">admin</span></span>
            </div>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('status'))
                    <div class="mb-6 bg-emerald-50 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (() => {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar_overlay');
            const openBtn = document.getElementById('sidebar_open');
            const closeBtn = document.getElementById('sidebar_close');

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };
            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            openBtn?.addEventListener('click', openSidebar);
            closeBtn?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);
        })();
    </script>
</body>
</html>