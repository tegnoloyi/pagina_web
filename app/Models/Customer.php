<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Los clientes de la tienda. Pueden existir sin password (checkout como
 * invitado) o con password (cuenta con login). El guard "customer" usa
 * este modelo por separado del modelo User (que es solo para el staff/admin).
 */
class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['email', 'name', 'phone', 'password', 'google_id', 'avatar_url'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Un cliente "tiene cuenta" si registró una contraseña; si no,
     * solo existe porque hizo una compra como invitado.
     */
    public function hasAccount(): bool
    {
        return ! is_null($this->password) || ! is_null($this->google_id);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\CustomerResetPasswordNotification($token));
    }
}
