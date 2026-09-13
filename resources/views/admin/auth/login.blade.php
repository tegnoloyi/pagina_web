<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Scorpio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-ink text-bone min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm p-8">
        <h1 class="text-xl font-bold uppercase tracking-widest text-center mb-8">SCORPIO <span class="text-bone-dim font-normal">admin</span></h1>

        @if ($errors->any())
            <div class="mb-6 bg-sting/10 text-sting text-sm px-4 py-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Correo" required autofocus
                   class="w-full bg-surface border border-line rounded-lg px-4 py-2.5 text-sm text-bone placeholder-bone-dim focus:outline-none focus:ring-1 focus:ring-venom">
            <input type="password" name="password" placeholder="Contraseña" required
                   class="w-full bg-surface border border-line rounded-lg px-4 py-2.5 text-sm text-bone placeholder-bone-dim focus:outline-none focus:ring-1 focus:ring-venom">
            <label class="flex items-center gap-2 text-xs text-bone-dim">
                <input type="checkbox" name="remember"> Recordarme
            </label>
            <button type="submit" class="w-full bg-venom text-ink font-bold text-sm uppercase tracking-wider px-8 py-3 rounded-lg hover:brightness-110 transition">
                Entrar
            </button>
        </form>
    </div>
</body>
</html>