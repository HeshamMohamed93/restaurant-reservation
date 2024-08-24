<?php

namespace App\Services;

class TaxServiceCheckout implements CheckoutStrategy
{
    public function calculateTotal($order)
    {
        $subtotal = $order->total;
        $tax = $subtotal * 0.14;
        $service = $subtotal * 0.20;
        return $subtotal + $tax + $service;
    }
}
