<?php

declare(strict_types=1);

namespace Glsv\SbisApi\vo;

enum TenderStatus: string
{
    case ACCEPTING_ORDERS = 'acceptingOrders';
    case FINISHED = 'finished';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACCEPTING_ORDERS => 'Прием заявок',
            self::FINISHED => 'Завершен',
            default => $this->value,
        };
    }
}