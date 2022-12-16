<?php

declare(strict_types=1);

namespace Glsv\SbisApi\dto\factory;

use Glsv\SbisApi\dto\TenderContactDto;

class TenderContactDtoFactory extends BaseDtoFactory
{
    protected static function getDtoFactoriesForGrouping(): array
    {
        return [];
    }

    static function create(array $data): TenderContactDto
    {
        return self::createInternal($data);
    }

    protected static function getDto(): TenderContactDto
    {
        return new TenderContactDto();
    }

    protected static function getDtoFactoriesForList(): array
    {
        return [];
    }
}