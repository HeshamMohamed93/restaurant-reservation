<?php

namespace App\Services;

interface CheckoutStrategy
{
    public function calculateTotal($order);
}
