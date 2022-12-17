<?php

namespace App\Services;

class TransferRequest
{
    private string $symbol;
    private int $amount;
    private string $userTransfer;
    private string $password;

    public function __construct(string $symbol, int $amount, string $userTransfer, string $password)
    {
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->userTransfer = $userTransfer;
        $this->password = $password;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getUserTransfer(): string
    {
        return $this->userTransfer;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}