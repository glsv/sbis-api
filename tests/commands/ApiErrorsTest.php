<?php

namespace commands;

use Glsv\SbisApi\commands\GetTenderListCommand;
use Glsv\SbisApi\exceptions\{SbisApiRuntimeException, SbisApiLimitException};
use Glsv\SbisApi\requests\GetTenderListRequest;
use Glsv\SbisApi\SbisClientApi;
use Glsv\SbisApi\vo\SbisErrorCode;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiErrorsTest extends TestCase
{
    private Client $client;

    private $defaultResponse = [
        "jsonrpc" => "2.0",
        "error" => [
            "code" => 0,
            "message" => "Error message",
            "data" => [
                "error_code" => -1
            ]
        ],
        "protocol" => 4
    ];

    public function setUp(): void
    {
        $this->client = $this->getMockBuilder(Client::class)->getMock();
    }

    public function _testError101()
    {
        $this->expectException(SbisApiRuntimeException::class);

        $data = $this->defaultResponse;
        $data['error']['data']['error_code'] = 101;

        $mockResponse = new Response(200, [], json_encode($data));
        $this->client->method('post')->willReturn($mockResponse);

        $api = new SbisClientApi("http://xyz.com", "token", $this->client);
        $command = new GetTenderListCommand($api, new GetTenderListRequest('name'));
        $command->execute();
    }

    /**
     * @dataProvider errorLimitCodes
     */
    public function testErrorLimit(SbisErrorCode $code)
    {
        $this->expectException(SbisApiLimitException::class);

        $data = $this->defaultResponse;
        $data['error']['data']['error_code'] = $code->value;

        $mockResponse = new Response(200, [], json_encode($data));
        $this->client->method('post')->willReturn($mockResponse);

        $api = new SbisClientApi("http://xyz.com", "token", $this->client);
        $command = new GetTenderListCommand($api, new GetTenderListRequest('name'));
        $command->execute();
    }

    protected function errorLimitCodes(): array
    {
        return [
            [SbisErrorCode::LIMIT_DAY_TENDERS],
            [SbisErrorCode::LIMIT_DAY_TENDERS_REQUESTED],
            [SbisErrorCode::LIMIT_NUMBER_TENDERS_ONCE],
            [SbisErrorCode::NUMBER_TENDERS_EXCEEDED_REST],
        ];
    }
}
