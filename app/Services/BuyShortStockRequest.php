<?php

namespace App\Services;

class BuyShortStockRequest
{
    private ?int $transactionId;
    private ?int $amount;

    public function __construct(?int $transactionId = null, ?int $amount = null)
    {
        $this->transactionId = $transactionId;
        $this->amount = $amount;
    }

    public function getTransactionId(): ?int
    {
        return $this->transactionId;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }
}