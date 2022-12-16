<?php

declare(strict_types=1);

namespace Glsv\SbisApi\vo\factory;
use Glsv\SbisApi\exceptions\SbisInvalidParamsException;
use Glsv\SbisApi\vo\TenderStatus;

class TenderStatusFactory
{
    public static function create(string $status): TenderStatus
    {
        return match ($status) {
          'Прием заявок' => TenderStatus::ACCEPTING_ORDERS,
            default => throw new SbisInvalidParamsException('text status of tender is unknown: ' . $status),
        };
    }
}