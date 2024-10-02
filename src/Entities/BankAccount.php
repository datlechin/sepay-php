<?php

declare(strict_types=1);

namespace Datlechin\SePay\Entities;

use DateTime;

class BankAccount
{
    public int $id;

    public string $accountNumber;

    public string $holderName;

    public float $accumulated;

    public ?string $alias;

    public bool $active;

    public DateTime $createdAt;

    public DateTime $lastTransaction;

    public Bank $bank;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->accountNumber = $data['account_number'];
        $this->holderName = $data['account_holder_name'];
        $this->accumulated = (float) $data['accumulated'];
        $this->alias = $data['label'] ?: null;
        $this->active = (bool) $data['active'];
        $this->createdAt = new DateTime($data['created_at']);
        $this->lastTransaction = new DateTime($data['last_transaction']);
        $this->bank = new Bank(
            $data['bank_short_name'],
            $data['bank_full_name'],
            (int) $data['bank_bin'],
            $data['bank_code'],
        );
    }
}
