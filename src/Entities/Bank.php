<?php

declare(strict_types=1);

namespace Datlechin\SePay\Entities;

class Bank
{
    public string $shortName;

    public ?string $fullName = null;

    public ?int $bin = null;

    public ?string $code = null;

    public function __construct(string $shortName, ?string $fullName = null, ?int $bin = null, ?string $code = null)
    {
        $this->shortName = $shortName;
        $this->fullName = $fullName;
        $this->bin = $bin;
        $this->code = $code;
    }
}
