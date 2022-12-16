<?php

declare(strict_types=1);

namespace Glsv\SbisApi\dto\factory;

use Glsv\SbisApi\dto\OrganizationDto;

class OrganizationDtoFactory extends BaseDtoFactory
{
    protected static function getDtoFactoriesForGrouping(): array
    {
        return [];
    }

    static function create(array $data): OrganizationDto
    {
        return self::createInternal($data);
    }

    protected static function getDto(): OrganizationDto
    {
        return new OrganizationDto();
    }

    protected static function getDtoFactoriesForList(): array
    {
        return [];
    }
}