<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('email', 120)->unique();
        $table->string('name', 120);
        $table->string('phone', 20)->nullable();
        $table->string('password')->nullable();
        $table->string('google_id')->nullable()->unique();
        $table->string('avatar_url')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
