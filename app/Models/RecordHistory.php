<?php

namespace App\Models;

class RecordHistory
{
    private int $buyId;
    private int $amount;
    private float $price;
    private string $symbol;
    private string $status;
    private string $date;

    public function __construct(
        int $buyId,
        int $amount,
        float $price,
        string $symbol,
        string $status,
        string $date
    )
    {
        $this->buyId = $buyId;
        $this->amount = $amount;
        $this->price = $price;
        $this->symbol = $symbol;
        $this->status = $status;
        $this->date = $date;
    }

    public function getBuyId(): int
    {
        return $this->buyId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}