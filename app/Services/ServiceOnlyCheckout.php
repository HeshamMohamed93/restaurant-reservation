<?php

namespace App\Services;

class ServiceOnlyCheckout implements CheckoutStrategy
{
    public function calculateTotal($order)
    {
        $subtotal = $order->total;
        $service = $subtotal * 0.15;
        return $subtotal + $service;
    }
}
