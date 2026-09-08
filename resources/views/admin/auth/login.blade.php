<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — VESTIR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-black text-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm p-8">
        <h1 class="text-xl font-bold uppercase tracking-widest text-center mb-8">VESTIR <span class="text-gray-500 font-normal">admin</span></h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-500/10 text-red-400 text-sm px-4 py-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Correo" required autofocus
                   class="w-full bg-white/10 border border-white/10 rounded-lg px-4 py-2.5 text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-white">
            <input type="password" name="password" placeholder="Contraseña" required
                   class="w-full bg-white/10 border border-white/10 rounded-lg px-4 py-2.5 text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-white">
            <label class="flex items-center gap-2 text-xs text-gray-400">
                <input type="checkbox" name="remember"> Recordarme
            </label>
            <button type="submit" class="w-full bg-white text-black font-medium text-sm uppercase tracking-wider px-8 py-3 rounded-lg hover:bg-gray-200">
                Entrar
            </button>
        </form>
    </div>
</body>
</html>
