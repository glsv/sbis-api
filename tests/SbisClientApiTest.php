<?php

declare(strict_types=1);

use Glsv\SbisApi\models\ApiResponse;
use Glsv\SbisApi\exceptions\{SbisApiRuntimeException, SbisApiUnauthorizedException, SbisInvalidParamsException};
use Glsv\SbisApi\SbisClientApi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SbisClientApiTest extends TestCase
{
    private Client $client;
    private $baseUrl = 'http://xyz.com';

    private string $errorContentResponse = '{
        "jsonrpc": "2.0",
        "error": {
            "code": -32601,
            "message": "Внутренняя ошибка сервера.\nПопробуйте выполнить операцию позднее.",
            "details": "The method SbisTenderAPI.GetTenderList1/1 is not found or accessible.",
            "type": "error",
            "data": {}
        },
        "id": null,
        "protocol": 4
    }';

    public function setUp(): void
    {
        $this->client = $this->getMockBuilder(Client::class)->getMock();
    }

    public function testErrorParsing()
    {
        $this->expectException(SbisApiRuntimeException::class);

        $response = new Response(200, [], 'Wrong format');
        $this->client->method('post')->willReturn($response);

        $api = new SbisClientApi($this->baseUrl, "token", $this->client);
        $api->makePost("method", []);
    }

    public function testErrorAuth()
    {
        $this->expectException(SbisApiUnauthorizedException::class);

        $response = new Response(401, [], 'format');
        $this->client->method('post')->willReturn($response);

        $api = new SbisClientApi($this->baseUrl, "token", $this->client);
        $api->makePost("method", []);
    }

    public function testErrorEmptyMethod()
    {
        $this->expectException(SbisInvalidParamsException::class);

        $response = new Response(200, [], 'format');
        $this->client->method('post')->willReturn($response);

        $api = new SbisClientApi($this->baseUrl, "token", $this->client);
        $api->makePost("", []);
    }

    public function testReceiveErrorResponseWith200(): void
    {
        $response = new Response(200, [], $this->errorContentResponse);
        $this->client->method('post')->willReturn($response);

        $api = new SbisClientApi($this->baseUrl, "token", $this->client);
        $result = $api->makePost("xxx", []);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertSame($result->isError(), true);
    }

    public function testReceiveErrorResponseWith400(): void
    {
        $response = new Response(400, [], $this->errorContentResponse);
        $this->client->method('post')->willReturn($response);

        $api = new SbisClientApi($this->baseUrl, "token", $this->client);
        $result = $api->makePost("xxx", []);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertSame($result->isError(), true);
    }

    /**
     * @dataProvider successHttpCodes
     */
    public function testSuccessWithHttpCode($httpCode): void
    {
        $content = '{
                        "jsonrpc": "2.0",
                        "result": null,
                        "id": null,
                        "protocol": 4
                    }';

        $response = new Response($httpCode, [], $content);
        $this->client->method('post')->willReturn($response);

        $api = new SbisClientApi($this->baseUrl, "token", $this->client);
        $result = $api->makePost("xxx", []);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertSame($result->isError(), false);
    }

    public function successHttpCodes(): array
    {
        return [
            [200],
            [400]
        ];
    }
}
