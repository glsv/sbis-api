<?php

declare(strict_types=1);

namespace Glsv\SbisApi\commands;

use Glsv\SbisApi\requests\GetTenderListRequest;
use Glsv\SbisApi\responses\GetTenderListResponse;
use Glsv\SbisApi\SbisClientApi;

class GetTenderListCommand
{
    protected $method = 'SbisTenderAPI.GetTenderList';

    public function __construct(protected SbisClientApi $api, protected GetTenderListRequest $request)
    {
    }

    public function execute(): GetTenderListResponse
    {
        $result = $this->api->executeRequest($this->method, $this->request);
        return new GetTenderListResponse($result['tenders']?? [], $result['tenders_count'] ?? 0);
    }
}