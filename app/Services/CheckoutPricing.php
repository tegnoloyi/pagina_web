<?php

namespace App\Services;

use App\Models\Customer;

class CheckoutPricing
{
    public const VALID_COUPONS = [
        'SCORPIO10' => 0.10,
        'VIP15' => 0.15,
        'AMIGO5' => 0.05,
    ];

    public static function calculate(float $subtotal, ?Customer $customer = null, ?string $couponCode = null, ?string $paymentMethod = null): array
    {
        $subtotal = max(0, $subtotal);
        $normalizedCoupon = strtoupper(trim((string) ($couponCode ?? '')));

        $couponRate = 0.0;
        $couponReason = null;
        if ($normalizedCoupon !== '' && array_key_exists($normalizedCoupon, self::VALID_COUPONS)) {
            $couponRate = (float) self::VALID_COUPONS[$normalizedCoupon];
            $couponReason = "Cupón {$normalizedCoupon}";
        }

        $loyaltyRate = 0.0;
        $loyaltyReason = null;
        if ($customer) {
            $lifetimeSpend = (float) $customer->orders()->sum('total');

            if ($lifetimeSpend >= 5000) {
                $loyaltyRate = 0.15;
                $loyaltyReason = 'Cliente frecuente';
            } elseif ($lifetimeSpend >= 2000 || $customer->orders()->count() >= 3) {
                $loyaltyRate = 0.10;
                $loyaltyReason = 'Cliente frecuente';
            } elseif ($customer->orders()->count() >= 1) {
                $loyaltyRate = 0.05;
                $loyaltyReason = 'Cliente recurrente';
            }
        }

        $paymentRate = 0.0;
        $paymentReason = null;
        if ($paymentMethod === 'transferencia') {
            $paymentRate = 0.10;
            $paymentReason = 'Transferencia';
        }

        $rates = [
            'coupon' => $couponRate,
            'loyalty' => $loyaltyRate,
            'payment' => $paymentRate,
        ];

        $bestRate = max($rates);
        $bestReason = match (true) {
            $couponRate > 0 && $couponRate === $bestRate => $couponReason,
            $loyaltyRate > 0 && $loyaltyRate === $bestRate => $loyaltyReason,
            $paymentRate > 0 && $paymentRate === $bestRate => $paymentReason,
            default => 'Sin descuento',
        };

        $discount = round($subtotal * $bestRate, 2);

        return [
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'rate' => round($bestRate, 4),
            'reason' => $bestReason,
            'has_coupon' => $couponRate > 0,
            'coupon_code' => $normalizedCoupon ?: null,
            'shipping_eta' => 'Tu pedido llega en 3 a 5 días hábiles.',
            'message' => $bestReason === 'Sin descuento' ? 'Aun así puedes usar un cupón o comprar más para sumar beneficios.' : "Descuento aplicado por {$bestReason}.",
        ];
    }
}
