<!DOCTYPE html>
<html lang="es" class="h-full dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ config('app.name') }}</title>

    <script>
        (function () {
            var saved = localStorage.getItem('escorpion-theme');
            if (saved === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[var(--c-ink)] text-[var(--c-bone)] antialiased font-sans">
    <div class="flex min-h-screen">
        <div id="sidebar_overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col border-r border-[var(--c-line)] bg-[var(--c-surface)] text-[var(--c-bone)] shadow-[0_0_30px_rgba(15,23,42,0.08)] transition-transform duration-200 ease-in-out -translate-x-full lg:static lg:w-64 lg:translate-x-0">
            <div class="flex h-16 items-center justify-between border-b border-[var(--c-line)] px-5">
                <div class="flex items-center gap-2 text-sm font-black uppercase tracking-[0.24em]">
                    <span class="text-[var(--c-bone)]">{{ strtoupper(config('app.name')) }}</span>
                    <span class="text-[9px] font-medium tracking-[0.12em] text-[var(--c-bone-dim)]">admin</span>
                </div>

                <button id="sidebar_close" class="rounded-lg p-1.5 text-[var(--c-bone-dim)] transition hover:bg-[var(--c-surface-2)] hover:text-[var(--c-bone)] lg:hidden" aria-label="Cerrar menú">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[var(--c-venom)]/10 text-[var(--c-venom)]' : 'text-[var(--c-bone-dim)] hover:bg-[var(--c-surface-2)] hover:text-[var(--c-bone)]' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-[var(--c-venom)]/10 text-[var(--c-venom)]' : 'text-[var(--c-bone-dim)] hover:bg-[var(--c-surface-2)] hover:text-[var(--c-bone)]' }}">
                    Productos
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-[var(--c-venom)]/10 text-[var(--c-venom)]' : 'text-[var(--c-bone-dim)] hover:bg-[var(--c-surface-2)] hover:text-[var(--c-bone)]' }}">
                    Categorías
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-[var(--c-venom)]/10 text-[var(--c-venom)]' : 'text-[var(--c-bone-dim)] hover:bg-[var(--c-surface-2)] hover:text-[var(--c-bone)]' }}">
                    Pedidos
                </a>
            </nav>

            <div class="border-t border-[var(--c-line)] p-3 space-y-2">
                <a href="{{ route('shop.index') }}" class="block rounded-xl px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.18em] text-[var(--c-bone-dim)] transition hover:bg-[var(--c-surface-2)] hover:text-[var(--c-bone)]">
                    ← Ver tienda
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-xl px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.18em] text-[var(--c-bone-dim)] transition hover:bg-[var(--c-surface-2)] hover:text-[var(--c-bone)]">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <div class="min-w-0 flex-1">
            <header class="sticky top-0 z-20 border-b border-[var(--c-line)] bg-[var(--c-surface)]/90 backdrop-blur-md">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6">
                    <div class="flex items-center gap-3 lg:hidden">
                        <button id="sidebar_open" class="rounded-lg p-2 text-[var(--c-bone)] transition hover:bg-[var(--c-surface-2)]" aria-label="Abrir menú">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <span class="text-sm font-black uppercase tracking-[0.22em]">{{ strtoupper(config('app.name')) }}</span>
                    </div>

                    <div class="hidden lg:block"></div>

                    <button
                        type="button"
                        id="theme_toggle"
                        class="inline-flex items-center gap-2 rounded-full border border-[var(--c-line)] bg-[var(--c-surface-2)] px-3 py-2 text-sm font-medium text-[var(--c-bone)] transition hover:border-[var(--c-venom)] hover:text-[var(--c-venom)]"
                        aria-label="Cambiar tema"
                    >
                        <svg class="block h-4 w-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg class="hidden h-4 w-4 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="hidden sm:inline">Modo</span>
                    </button>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-600 dark:text-emerald-400">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-600 dark:text-red-400">
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
            const themeToggle = document.getElementById('theme_toggle');

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

            themeToggle?.addEventListener('click', () => {
                const root = document.documentElement;
                const isDark = root.classList.toggle('dark');
                localStorage.setItem('escorpion-theme', isDark ? 'dark' : 'light');
            });
        })();
    </script>
</body>
</html>