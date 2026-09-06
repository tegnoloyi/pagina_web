<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('product_variants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        $table->string('sku', 60)->unique();
        $table->string('size', 10);
        $table->string('color', 30);
        $table->char('color_hex', 7)->nullable();
        $table->integer('stock')->default(0);
        $table->decimal('price', 10, 2)->nullable();
        $table->timestamps();

        $table->unique(['product_id', 'size', 'color']);
    });
}
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
