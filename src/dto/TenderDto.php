<?php

declare(strict_types=1);

namespace Glsv\SbisApi\dto;

use Glsv\SbisApi\vo\Currency;
use Glsv\SbisApi\vo\TenderStatus;

class TenderDto
{
    public array $categories = [];
    public ?TenderContactDto $contact = null;
    public ?OrganizationDto $initiator = null;
    public ?OrganizationDto $organizer = null;
    public ?TenderMetaDto $tender = null;
    /**
     * @var DocumentDto[]
     */
    public array $docs = [];
    public int $id;
    public ?\DateTime $last_modified_date = null;
    public array $lots = [];
    public string $name = '';
    public string $number = '';
    public ?\DateTime $publish_date = null;
    public ?\DateTime $sbis_publish_date = null;
    public ?\DateTime $tender_date = null;
    public ?\DateTime $request_receiving_date = null;
    public ?\DateTime $request_receiving_end_date = null;
    public string $region = '';
    public ?int $region_code = null;
    public ?TenderStatus $status = null;
    public string $type = '';
    public ?Currency $currency = null;
    public ?float $price = null;
    public ?int $prepayment_percent = null;
}