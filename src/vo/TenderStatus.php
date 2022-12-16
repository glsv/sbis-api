<?php

declare(strict_types=1);

namespace Glsv\SbisApi\vo;
enum TenderStatus: string
{
    case ACCEPTING_ORDERS = 'acceptingOrders';

    public function getLabel(): string
    {
        return match ($this) {
          self::ACCEPTING_ORDERS => 'Прием заявок',
          default => $this->value,
        };
    }
}