<?php

declare(strict_types=1);

namespace Glsv\SbisApi\requests;

use Glsv\SbisApi\interfaces\RequestInterface;
use Glsv\SbisApi\vo\SortOrder;

class GetTenderListRequest implements RequestInterface
{
    public int $limit = 10;
    public ?\DateTime $fromPublishDateTime = null;
    public ?\DateTime $toPublishDateTime = null;
    public ?\DateTime $fromLastModifiedDateTime = null;
    public ?\DateTime $toLastModifiedDateTime = null;
    public ?string $orderField = null;
    public ?SortOrder $sortOrder = null;

    public function __construct(public string $requestName)
    {
    }

    public function buildBody(): array
    {
        $body = [
            'requestName' => $this->requestName,
            'limit' => $this->limit,
        ];

        $body['fromPublishDateTime'] = $this->fromPublishDateTime?->format("Y-m-d H:i:s");
        $body['toPublishDateTime'] = $this->toPublishDateTime?->format("Y-m-d H:i:s");

        return $body;
    }
}