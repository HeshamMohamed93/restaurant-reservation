<?php

namespace App\Utils;

class PaymentType
{
    public const TAX_SERVICE = 'tax_service';
    public const SERVICE_ONLY = 'service_only';

    /**
     * Get all payment types.
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::TAX_SERVICE,
            self::SERVICE_ONLY,
        ];
    }
}
