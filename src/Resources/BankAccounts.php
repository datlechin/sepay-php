<?php

declare(strict_types=1);

namespace Datlechin\SePay\Resources;

use Datlechin\SePay\Entities\BankAccount;

class BankAccounts extends Resource
{
    protected string $resource = 'bankaccounts';

    /**
     * @return BankAccount[]|null
     */
    public function list(): ?array
    {
        $response = $this->request('GET', 'list');

        if (! isset($response['status']) || $response['status'] !== 200) {
            return null;
        }

        return array_map(
            fn($data) => new BankAccount($data),
            $response['bankaccounts'],
        );
    }

    public function get(int $id): ?BankAccount
    {
        $response = $this->request('GET', "details/$id");

        if (! isset($response['status']) || $response['status'] !== 200) {
            return null;
        }

        return new BankAccount($response['bankaccount']);
    }

    public function count(): ?int
    {
        $response = $this->request('GET', 'count');

        if (! isset($response['status']) || $response['status'] !== 200) {
            return null;
        }

        return $response['count_bankaccounts'];
    }
}
