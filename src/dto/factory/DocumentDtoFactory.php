<?php

declare(strict_types=1);

namespace Glsv\SbisApi\dto\factory;

use Glsv\SbisApi\dto\DocumentDto;

class DocumentDtoFactory extends BaseDtoFactory
{
    static function create(array $data): DocumentDto
    {
        return self::createInternal($data);
    }

    protected static function getDtoFactoriesForGrouping(): array
    {
        return [];
    }

    protected static function getDto(): DocumentDto
    {
        return new DocumentDto();
    }

    protected static function getDtoFactoriesForList(): array
    {
        return [];
    }
}