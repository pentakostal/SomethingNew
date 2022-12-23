<?php

namespace App\Models;

class ShortStock
{
    private int $transactionId;
    private int $userId;
    private string $symbol;
    private float $price;
    private int $amount;

    public function __construct(int $transactionId, int $userId, string $symbol, float $price, int $amount)
    {
        $this->transactionId = $transactionId;
        $this->userId = $userId;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->amount = $amount;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
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