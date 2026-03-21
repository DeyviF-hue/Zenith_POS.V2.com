<?php

namespace App\Helpers;

class PriceHelper
{
    /**
     * Format money amount with currency suffix.
     */
    public static function formatMoney(float $amount, string $currency = 'USD'): string
    {
        // Simple formatting: 2 decimals, comma as thousands separator
        return number_format($amount, 2, '.', ',') . ' ' . $currency;
    }

    /**
     * Calculate a total with tax and optional discount.
     */
    public static function calculateTotal(float $subtotal, float $taxRate = 0.08, float $discount = 0.0): float
    {
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax - $discount;
        return max(0, $total);
    }
}
