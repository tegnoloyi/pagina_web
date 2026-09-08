<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Único dato que se siembra: el usuario admin para poder entrar a
        // /admin/login. Categorías, productos, variantes, clientes y
        // pedidos de prueba se quitaron a propósito: la carga real de
        // catálogo se hace desde el panel admin cuando esté listo.
        User::updateOrCreate(
            ['email' => 'admin@vestir.test'],
            ['name' => 'Admin', 'password' => 'password']
        );
    }
}
