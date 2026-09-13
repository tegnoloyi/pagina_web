<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Único dato que se siembra: el usuario admin para poder entrar a
        // /admin/login. Categorías, productos, variantes, clientes y
        // pedidos de prueba se quitaron a propósito: la carga real de
        // catálogo se hace desde el panel admin cuando esté listo.
        //
        // La contraseña NUNCA es un valor fijo en el código. Se toma de
        // ADMIN_SEED_PASSWORD en el .env (para desarrollo/staging donde sí
        // quieres una contraseña conocida); si no está definida, se genera
        // una aleatoria y se imprime una sola vez en consola para que el
        // admin la cambie de inmediato desde el panel.
        $email = env('ADMIN_SEED_EMAIL', 'admin@vestir.test');
        $password = env('ADMIN_SEED_PASSWORD');
        $generated = false;

        if (blank($password)) {
            $password = Str::password(16);
            $generated = true;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
            ]
        );

        if ($generated) {
            $this->command?->warn("Admin creado: {$email} / contraseña generada: {$password}");
            $this->command?->warn('Guárdala ahora y cámbiala desde el panel en cuanto entres.');
        }
    }
}