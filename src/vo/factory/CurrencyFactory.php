<?php

declare(strict_types=1);

namespace Glsv\SbisApi\vo\factory;

use Glsv\SbisApi\exceptions\SbisInvalidParamsException;
use Glsv\SbisApi\vo\Currency;

class CurrencyFactory
{
    public static function create(string $code): Currency
    {
        return match ($code) {
            'RUB' => Currency::RUB,
            'USD' => Currency::USD,
            'EUR' => Currency::EUR,
            'BYN' => Currency::BYN,
            'KZT' => Currency::KZT,
            default => throw new SbisInvalidParamsException('currency code is unknown: ' . $code),
        };
    }
}