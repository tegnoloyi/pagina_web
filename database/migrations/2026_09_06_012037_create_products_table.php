<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        $table->string('name', 120);
        $table->text('description')->nullable();
        $table->text('material')->nullable();
        $table->decimal('base_price', 10, 2);
        $table->decimal('old_price', 10, 2)->nullable();
        $table->boolean('is_new')->default(false);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
