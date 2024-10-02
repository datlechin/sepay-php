<?php

declare(strict_types=1);

namespace Tests\Unit;

use Datlechin\SePay\SePay;
use Datlechin\SePay\Client;
use Datlechin\SePay\Webhook\Webhook;
use PHPUnit\Framework\TestCase;

class SePayTest extends TestCase
{
    public function testClient()
    {
        $apiKey = 'test_api_key';
        $client = SePay::client($apiKey);
        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals($apiKey, $client->getApiKey());
    }

    public function testWebhook()
    {
        $webhook = SePay::webhook();
        $this->assertInstanceOf(Webhook::class, $webhook);
    }
}
