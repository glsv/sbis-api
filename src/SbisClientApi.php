<?php

declare(strict_types=1);

namespace Glsv\SbisApi;

use Glsv\SbisApi\interfaces\{ApiResponseInterface, RequestInterface};
use Glsv\SbisApi\exceptions\{SbisApiException,
    SbisApiRuntimeException,
    SbisApiUnauthorizedException,
    SbisInvalidParamsException};
use Glsv\SbisApi\models\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;

class SbisClientApi
{
    protected string $jsonrpc = "2.0";
    protected int $protocol = 4;

    /**
     * @var Client|ClientInterface
     */
    protected $client;

    protected string $domain = '';

    public function __construct(protected string $baseUrl, protected string $token, ?ClientInterface $httpClient = null)
    {
        $domain = parse_url($this->baseUrl, PHP_URL_HOST);
        if (!$domain) {
           throw new SbisInvalidParamsException('couldn`t receive domain from baseUrl: ' . $baseUrl);
        }

        $this->domain = $domain;

        if ($httpClient) {
            $this->client = $httpClient;

        } else {
            $this->client = new Client(['base_uri' => $baseUrl]);
        }
    }

    public function makePost(string $method, array $params): ApiResponseInterface
    {
        $jar = CookieJar::fromArray(
            [
                'sid' => $this->token,
            ],
            $this->domain
        );

        $requestBody = $this->buildRequestBody($method, $params);

        try {
            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'Content-Type' => 'application/json; utf-8'
                ],
                'http_errors' => false,
                'cookies' => $jar,
                'body' => json_encode($requestBody),
            ]);
        } catch (\Throwable $exc) {
            throw new SbisApiRuntimeException(
                "Error execute request. \n" .
                "Origin error: " . $exc->getMessage() . "\n".
                $this->buildErrorMessage($method, $requestBody) . " \n",
                $exc->getCode(),
            );
        }

        try {
            return $this->handleResponse($response);
        } catch (SbisApiException $exc) {
            throw $exc;
        } catch (\Throwable $exc) {
            throw new SbisApiRuntimeException(
                "Error execute request. \n" .
                $this->buildErrorMessage($method, $requestBody) . " \n: " . $exc->getMessage(),
                $exc->getCode(),
                $exc
            );
        }
    }

    public function executeRequest(string $method, RequestInterface $request): array
    {
        $response = $this->makePost($method, $request->buildBody());

        if ($response->isError()) {
            throw new SbisApiRuntimeException("Error response: " . $response);
        }

        return $response->getResult();
    }

    protected function handleResponse(ResponseInterface $response): ApiResponseInterface
    {
        $statusCode = $response->getStatusCode();

        switch ($statusCode) {
            case 401:
                throw new SbisApiUnauthorizedException("401 Unauthorized.");
            case 403:
                throw new SbisApiUnauthorizedException("403 Forbidden.");
        }

        try {
            $data = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $exc) {
            throw new SbisApiRuntimeException(
                "Https status code: $statusCode \n" .
                "Error parsing response:\n------------" .
                mb_substr((string)$response->getBody(), 0, 100) . "...\n" .
                "------------\n"
            );
        }

        return ApiResponse::create($data);
    }

    protected function buildErrorMessage(string $method, array $requestBody): string
    {
        return sprintf(
            "\tUrl: %s;\n\tMethod: %s;\n\tRequest Body: %s;\n",
            $this->baseUrl, $method, json_encode($requestBody)
        );
    }

    protected function buildRequestBody(string $method, array $params): array
    {
        if ($method === "") {
            throw new SbisInvalidParamsException("method is empty");
        }

        return [
            'jsonrpc' => $this->jsonrpc,
            'protocol' => $this->protocol,
            'method' => $method,
            'params' => [
                'params' => $params
            ],
        ];
    }
}