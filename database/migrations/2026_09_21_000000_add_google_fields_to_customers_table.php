<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega las columnas de Google a "customers" sin tocar nada más.
     * Usa hasColumn() por seguridad, en caso de que alguna ya exista
     * por otra vía y evitar un error de "columna duplicada".
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (! Schema::hasColumn('customers', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('email');
            }
            if (! Schema::hasColumn('customers', 'avatar_url')) {
                $table->string('avatar_url')->nullable()->after('google_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar_url']);
        });
    }
};