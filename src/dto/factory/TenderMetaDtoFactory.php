<?php

declare(strict_types=1);

namespace Glsv\SbisApi\dto\factory;

use Glsv\SbisApi\dto\TenderMetaDto;

class TenderMetaDtoFactory extends BaseDtoFactory
{
    static function create(array $data): TenderMetaDto
    {
        return self::createInternal($data);
    }

    protected static function getDtoFactoriesForGrouping(): array
    {
        return [];
    }

    protected static function getDto(): TenderMetaDto
    {
        return new TenderMetaDto();
    }

    protected static function getDtoFactoriesForList(): array
    {
        return [];
    }
}