<?php

namespace commands;

use Glsv\SbisApi\commands\GetTenderListCommand;
use Glsv\SbisApi\dto\{OrganizationDto, TenderContactDto, TenderDto};
use Glsv\SbisApi\requests\GetTenderListRequest;
use Glsv\SbisApi\responses\GetTenderListResponse;
use Glsv\SbisApi\SbisClientApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetTenderListCommandTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = $this->getMockBuilder(Client::class)->getMock();
    }

    public function testSuccess(): TenderDto
    {
        $content = file_get_contents(__DIR__ . '/../data/responses/GetTenderList.json');

        $mockResponse = new Response(200, [], $content);
        $this->client->method('post')->willReturn($mockResponse);

        $api = new SbisClientApi("http://xyz.com", "token", $this->client);
        $command = new GetTenderListCommand($api, new GetTenderListRequest('name'));
        $resultResponse = $command->execute();

        $this->assertInstanceOf(GetTenderListResponse::class, $resultResponse);
        $this->assertSame(1, count($resultResponse->tenders));

        return $resultResponse->tenders[0];
    }

    /**
     * @depends testSuccess
     */
    public function testAttrs(TenderDto $tender)
    {
        $this->assertSame('9354300021322000001_1', $tender->number);
        $this->assertSame('Орловская обл', $tender->region);
        $this->assertSame(2340996.0, $tender->price);
        $this->assertSame('RUB', $tender->currency->value);
    }

    /**
     * @depends testSuccess
     */
    public function testContact(TenderDto $tender)
    {
        $this->assertInstanceOf(TenderContactDto::class, $tender->contact);
        $this->assertSame('Фамилия Лариса Павловна', $tender->contact->person_name);
        $this->assertSame('name@xyz.com', $tender->contact->email);
        $this->assertSame('7-8888-21111', $tender->contact->phone);
    }

    /**
     * @depends testSuccess
     */
    public function testOrganizator(TenderDto $tender)
    {
        $this->assertInstanceOf(OrganizationDto::class, $tender->organizer);
        $this->assertSame('9917020024', $tender->organizer->inn, 'comparing INN');

        $this->assertInstanceOf(OrganizationDto::class, $tender->initiator);
        $this->assertSame('991701001', $tender->organizer->kpp, 'comparing KPP');
    }

    /**
     * @depends testSuccess
     */
    public function testInitiator(TenderDto $tender)
    {
        $this->assertInstanceOf(OrganizationDto::class, $tender->organizer);
        $this->assertSame('8817020024', $tender->initiator->inn, 'comparing INN');

        $this->assertInstanceOf(OrganizationDto::class, $tender->initiator);
        $this->assertSame('881701001', $tender->initiator->kpp, 'comparing KPP');
    }
}