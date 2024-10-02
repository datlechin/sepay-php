<?php

declare(strict_types=1);

namespace Datlechin\SePay;

use Datlechin\SePay\Resources\BankAccounts;
use Datlechin\SePay\Resources\Transactions;
use GuzzleHttp\Client as HttpClient;
use InvalidArgumentException;

class Client
{
    protected ?string $apiKey = null;

    protected string $apiUrl = 'https://my.sepay.vn';

    protected HttpClient $client;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;

        if (empty($this->apiKey)) {
            throw new InvalidArgumentException('Vui lòng cung cấp API key.');
        }

        $this->client = new HttpClient([
            'base_uri' => $this->apiUrl,
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $this->apiKey",
            ],
        ]);
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function get(string $uri, array $query = []): ?array
    {
        $response = $this->client->get($uri, [
            'query' => $query,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function transactions(): Transactions
    {
        return new Transactions($this);
    }

    public function bankAccounts(): BankAccounts
    {
        return new BankAccounts($this);
    }
}
