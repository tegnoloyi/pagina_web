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

        // Snapshot de datos del cliente al momento de la compra (aunque tenga cuenta,
        // así el pedido no cambia si el cliente edita su perfil después)
        $table->string('customer_name', 120);
        $table->string('customer_email', 120);
        $table->string('customer_phone', 20)->nullable();

        // Envío
        $table->string('shipping_address', 255);
        $table->string('shipping_city', 100);
        $table->string('shipping_state', 100);
        $table->string('shipping_zip', 15);

        // Pago
        $table->string('payment_method', 20)->default('efectivo'); // efectivo | transferencia | tarjeta
        $table->boolean('is_paid')->default(false);
        $table->timestamp('paid_at')->nullable();

        $table->text('notes')->nullable();

        $table->string('status', 20)->default('pendiente'); // pendiente|pagado|procesando|enviado|entregado|cancelado
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
