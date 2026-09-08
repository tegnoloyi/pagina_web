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
        <!-- SIDEBAR -->
        <aside class="w-60 bg-black text-white flex-shrink-0 flex flex-col">
            <div class="h-16 flex items-center px-6 text-lg font-bold tracking-widest uppercase border-b border-white/10">
                VESTIR
                <span class="text-[10px] font-normal tracking-normal normal-case text-gray-400 ml-2">admin</span>
            </div>
            <nav class="flex-1 px-3 py-6 space-y-1 text-sm">
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
            <main class="p-8">
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
</body>
</html>
