<?php

declare(strict_types=1);

namespace Glsv\SbisApi\dto\factory;

use Glsv\SbisApi\dto\TenderDto;
use Glsv\SbisApi\vo\Currency;
use Glsv\SbisApi\vo\factory\TenderStatusFactory;

class TenderDtoFactory extends BaseDtoFactory
{
    public static function create(array $data): TenderDto
    {
        $m = self::createInternal($data);

        if ($data['status']) {
            $m->status = TenderStatusFactory::create($data['status']);
        }

        if (isset($data['currency_code']) && $data['currency_code']) {
            $m->currency = new Currency($data['currency_code']);
        }

        return $m;
    }

    protected static $excludeAttrs = [
        'status',
    ];

    protected static $dateTimeAttrs = [
        'publish_date',
        'sbis_publish_date',
        'last_modified_date',
        'tender_date',
        'request_receiving_date',
        'request_receiving_end_date'
    ];

    protected static function getDtoFactoriesForGrouping(): array
    {
        return [
            'initiator_' => OrganizationDtoFactory::class,
            'contact_' => TenderContactDtoFactory::class,
            'organizer_' => OrganizationDtoFactory::class,
            'tender_' => TenderMetaDtoFactory::class,
        ];
    }

    protected static function getDtoFactoriesForList(): array
    {
        return [
            'docs' => DocumentDtoFactory::class
        ];
    }

    protected static function getDto(): TenderDto
    {
        return new TenderDto();
    }
}