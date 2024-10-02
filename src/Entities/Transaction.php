<?php

declare(strict_types=1);

namespace Datlechin\SePay\Entities;

use DateTime;

class Transaction
{
    public int $id;

    public Bank $bank;

    public string $accountNumber;

    public DateTime $transactionDate;

    public float $amountOut;

    public float $amountIn;

    public float $accumulated;

    public string $content;

    public string $referenceNumber;

    public ?string $code = null;

    public ?string $subAccount = null;

    public int $bankAccountId;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->bank = new Bank($data['bank_brand_name']);
        $this->accountNumber = $data['account_number'];
        $this->transactionDate = new DateTime($data['transaction_date']);
        $this->amountOut = (float) $data['amount_out'];
        $this->amountIn = (float) $data['amount_in'];
        $this->accumulated = (float) $data['accumulated'];
        $this->content = $data['transaction_content'];
        $this->referenceNumber = $data['reference_number'];
        $this->code = $data['code'];
        $this->subAccount = $data['sub_account'];
        $this->bankAccountId = (int) $data['bank_account_id'];
    }
}
