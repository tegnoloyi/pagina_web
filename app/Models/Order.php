<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = [
        'pendiente', 'pagado', 'procesando', 'enviado', 'entregado', 'cancelado',
    ];

    public const PAYMENT_METHODS = ['efectivo', 'transferencia', 'tarjeta'];

    protected $fillable = [
        'customer_id',
        'customer_name', 'customer_email', 'customer_phone',
        'shipping_address', 'shipping_city', 'shipping_state', 'shipping_zip',
        'payment_method', 'is_paid', 'paid_at', 'notes',
        'status', 'subtotal', 'shipping', 'total',
    ];

    protected function casts(): array
    {
        return [
            'is_paid' => 'boolean',
            'paid_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'shipping' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function markAsPaid(): void
    {
        $this->update([
            'is_paid' => true,
            'paid_at' => now(),
            'status' => $this->status === 'pendiente' ? 'pagado' : $this->status,
        ]);
    }
}
