<?php

namespace App\Services;

use App\Models\ProductVariant;
use Illuminate\Support\Collection;

/**
 * Carrito basado en sesión. Funciona igual para invitados y clientes
 * logueados; solo al hacer checkout se asocia a un Customer.
 *
 * Estructura en sesión: ['variant_id' => qty, ...]
 */
class CartService
{
    protected const SESSION_KEY = 'cart';

    protected function raw(): array
    {
        return session(self::SESSION_KEY, []);
    }

    protected function save(array $cart): void
    {
        session([self::SESSION_KEY => $cart]);
    }

    public function add(int $variantId, int $qty = 1): void
    {
        $cart = $this->raw();
        $cart[$variantId] = ($cart[$variantId] ?? 0) + $qty;
        $this->save($cart);
    }

    public function update(int $variantId, int $qty): void
    {
        $cart = $this->raw();

        if ($qty <= 0) {
            unset($cart[$variantId]);
        } else {
            $cart[$variantId] = $qty;
        }

        $this->save($cart);
    }

    public function remove(int $variantId): void
    {
        $cart = $this->raw();
        unset($cart[$variantId]);
        $this->save($cart);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function isEmpty(): bool
    {
        return count($this->raw()) === 0;
    }

    public function count(): int
    {
        return array_sum($this->raw());
    }

    /**
     * Devuelve las líneas del carrito con producto/variante ya cargados,
     * el precio vigente y el subtotal por línea. Si una variante fue
     * eliminada o dejó de tener stock suficiente, se marca en la línea
     * en vez de tronar.
     */
    public function lines(): Collection
    {
        $cart = $this->raw();

        if (empty($cart)) {
            return collect();
        }

        $variants = ProductVariant::with(['product.images'])
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        return collect($cart)->map(function ($qty, $variantId) use ($variants) {
            $variant = $variants->get($variantId);

            if (! $variant) {
                return null;
            }

            $price = (float) ($variant->price ?? $variant->product->base_price);

            return [
                'variant' => $variant,
                'qty' => $qty,
                'price' => $price,
                'line_total' => round($price * $qty, 2),
                'available' => $variant->stock >= $qty,
            ];
        })->filter()->values();
    }

    public function subtotal(): float
    {
        return round($this->lines()->sum('line_total'), 2);
    }

    /**
     * true si alguna línea pide más cantidad de la que hay en stock.
     */
    public function hasStockIssues(): bool
    {
        return $this->lines()->contains(fn ($line) => ! $line['available']);
    }
}
