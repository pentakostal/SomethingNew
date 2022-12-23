<?php

namespace App\Models;

class UserStockBankShort
{
    private int $transactionId;
    private string $symbol;
    private float $price;
    private int $amount;

    public function __construct(int $transactionId, string $symbol, float $price, int $amount)
    {
        $this->transactionId = $transactionId;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->amount = $amount;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}