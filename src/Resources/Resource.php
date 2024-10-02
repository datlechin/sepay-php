<?php

declare(strict_types=1);

namespace Datlechin\SePay\Resources;

use Datlechin\SePay\Client;

abstract class Resource
{
    protected Client $client;

    protected string $resource;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function request(string $method, string $uri, array $data = []): ?array
    {
        $uri = "userapi/$this->resource/$uri";

        return $this->client->{$method}($uri, $data);
    }
}
