<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->nullable()->constrained('customers');
        $table->string('status', 20)->default('pendiente');
        $table->decimal('subtotal', 10, 2);
        $table->decimal('shipping', 10, 2)->default(99.00);
        $table->decimal('total', 10, 2);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
