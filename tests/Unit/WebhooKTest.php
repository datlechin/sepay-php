<?php

declare(strict_types=1);

namespace Tests\Unit\Webhook;

use Datlechin\SePay\Webhook\Webhook;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    public function testConstructorWithDefaultValues()
    {
        $webhook = new Webhook();
        $this->assertInstanceOf(Webhook::class, $webhook);
    }

    public function testConstructorWithCustomValues()
    {
        $webhook = new Webhook(Webhook::AUTH_API_KEY, 'test_token');
        $this->assertInstanceOf(Webhook::class, $webhook);
    }

    public function testSetAuthorizationWithValidType()
    {
        $webhook = new Webhook();
        $webhook->setAuthorization(Webhook::AUTH_API_KEY, 'test_token');
        $this->assertInstanceOf(Webhook::class, $webhook);
    }

    public function testSetAuthorizationWithInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);
        $webhook = new Webhook();
        $webhook->setAuthorization('invalid_type');
    }

    public function testAuthorizeWithNoAuth()
    {
        $webhook = new Webhook();
        $this->assertTrue($webhook->authorize());
    }

    public function testAuthorizeWithApiKey()
    {
        $webhook = new Webhook(Webhook::AUTH_API_KEY, 'test_token');
        $this->assertFalse($webhook->authorize());
    }

    public function testAuthorizeWithApiKeyAndValidHeader()
    {
        $webhook = $this->getMockBuilder(Webhook::class)
            ->setConstructorArgs([Webhook::AUTH_API_KEY, 'test_token'])
            ->onlyMethods(['getHeaders'])
            ->getMock();

        $webhook->method('getHeaders')->willReturn(['Authorization' => 'Apikey test_token']);
        $this->assertTrue($webhook->authorize());
    }

    public function testValidatePayloadWithValidData()
    {
        $webhook = new Webhook();
        $payload = [
            'id' => 1,
            'gateway' => 'gateway',
            'transactionDate' => '2023-10-01',
            'accountNumber' => '123456789',
            'transferType' => 'type',
            'transferAmount' => 1000,
            'accumulated' => 2000,
            'referenceCode' => 'ref123',
        ];
        $this->assertTrue($webhook->validatePayload($payload));
    }

    public function testValidatePayloadWithInvalidData()
    {
        $webhook = new Webhook();
        $payload = [
            'id' => 'invalid',
            'gateway' => 'gateway',
            'transactionDate' => '2023-10-01',
            'accountNumber' => '123456789',
            'transferType' => 'type',
            'transferAmount' => 1000,
            'accumulated' => 2000,
            'referenceCode' => 'ref123',
        ];
        $this->assertFalse($webhook->validatePayload($payload));
    }
}
