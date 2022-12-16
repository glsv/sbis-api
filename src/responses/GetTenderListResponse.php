<?php

declare(strict_types=1);

namespace Glsv\SbisApi\responses;

use Glsv\SbisApi\dto\factory\TenderDtoFactory;

class GetTenderListResponse
{
    public array $tenders;
    public int $count;

    public function __construct(array $tenders, int $count)
    {
        $this->count = $count;

        foreach ($tenders as $tender) {
            $this->tenders[] = TenderDtoFactory::create($tender);
        }
    }
}