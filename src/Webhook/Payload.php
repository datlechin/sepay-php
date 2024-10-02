<?php

declare(strict_types=1);

namespace Datlechin\SePay\Webhook;

use DateTime;
use Datlechin\SePay\Entities\Bank;

class Payload
{
    public int $id;

    public Bank $bank;

    public DateTime $transactionDate;

    public string $accountNumber;

    public ?string $code;

    public string $content;

    public string $type;

    public float $amount;

    public float $accumulated;

    public ?string $subAccount;

    public string $referenceCode;

    public string $description;

    public function __construct(array $payload)
    {
        $this->id = $payload['id'];
        $this->bank = new Bank($payload['gateway']);
        $this->transactionDate = new DateTime($payload['transactionDate']);
        $this->accountNumber = $payload['accountNumber'];
        $this->code = $payload['code'];
        $this->content = $payload['content'];
        $this->type = $payload['transferType'];
        $this->amount = (float) $payload['transferAmount'];
        $this->accumulated = (float) $payload['accumulated'];
        $this->subAccount = $payload['subAccount'];
        $this->referenceCode = $payload['referenceCode'];
        $this->description = $payload['description'];
    }
}
