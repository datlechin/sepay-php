<?php

declare(strict_types=1);

namespace Datlechin\SePay;

use Datlechin\SePay\Webhook\Webhook;

class SePay
{
    public static function client(string $apiKey): Client
    {
        return new Client($apiKey);
    }

    public static function webhook(): Webhook
    {
        return new Webhook();
    }
}
