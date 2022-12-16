<?php

declare(strict_types=1);

namespace Glsv\SbisApi\vo;

enum Currency: string
{
    case RUB = 'RUB';
    case USD = 'USD';
    case EUR = 'EUR';
    case BYN = 'BYN';
    case KZT = 'KZT';
}