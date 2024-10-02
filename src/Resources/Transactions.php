<?php

declare(strict_types=1);

namespace Datlechin\SePay\Resources;

use Datlechin\SePay\Entities\Transaction;

class Transactions extends Resource
{
    protected string $resource = 'transactions';

    /**
     * @return Transaction[]|null
     */
    public function list(array $query = []): ?array
    {
        $response = $this->request('GET', 'list', $query);

        if (! isset($response['status']) || $response['status'] !== 200) {
            return null;
        }

        return array_map(
            fn($data) => new Transaction($data),
            $response['transactions'],
        );
    }

    public function get(string $id): ?Transaction
    {
        $response = $this->request('GET', "details/$id");

        if (! isset($response['status']) || $response['status'] !== 200) {
            return null;
        }

        return new Transaction($response['transaction']);
    }

    public function count(array $query = []): ?array
    {
        $response = $this->request('GET', 'count', $query);

        if (! isset($response['status']) || $response['status'] !== 200) {
            return null;
        }

        return $response['count_transactions'];
    }
}
