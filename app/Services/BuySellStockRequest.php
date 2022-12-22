<?php

namespace App\Services;

class BuySellStockRequest
{
    private string $symbol;
    private int $amount;

    public function __construct(string $symbol, int $amount)
    {
        $this->symbol = $symbol;
        $this->amount = $amount;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}