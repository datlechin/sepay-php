<?php

declare(strict_types=1);

namespace Tests\Unit;

use Datlechin\SePay\Client;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testConstructorWithValidApiKey()
    {
        $apiKey = 'valid_api_key';
        $client = new Client($apiKey);
        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals($apiKey, $client->getApiKey());
    }

    public function testConstructorWithEmptyApiKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Vui lòng cung cấp API key.');
        new Client('');
    }

    public function testGetApiKey()
    {
        $apiKey = 'test_api_key';
        $client = new Client($apiKey);
        $this->assertEquals($apiKey, $client->getApiKey());
    }

    public function testGet()
    {
        $apiKey = 'test_api_key';
        $client = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$apiKey])
            ->onlyMethods(['get'])
            ->getMock();

        $client->expects($this->once())
            ->method('get')
            ->with('/test-uri', ['param' => 'value'])
            ->willReturn(['response' => 'data']);

        $response = $client->get('/test-uri', ['param' => 'value']);
        $this->assertEquals(['response' => 'data'], $response);
    }

    public function testTransactions()
    {
        $apiKey = 'test_api_key';
        $client = new Client($apiKey);
        $transactions = $client->transactions();
        $this->assertInstanceOf(\Datlechin\SePay\Resources\Transactions::class, $transactions);
    }

    public function testBankAccounts()
    {
        $apiKey = 'test_api_key';
        $client = new Client($apiKey);
        $bankAccounts = $client->bankAccounts();
        $this->assertInstanceOf(\Datlechin\SePay\Resources\BankAccounts::class, $bankAccounts);
    }
}
