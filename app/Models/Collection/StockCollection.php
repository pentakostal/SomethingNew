<?php

namespace App\Models\Collection;

use App\Models\StockProfile;
class StockCollection
{
    private array $stocks = [];

    public function __construct(array $stocks = [])
    {
        foreach ($stocks as $stock) {
            $this->add($stock);
        }
    }

    public function add(StockProfile $stock): void
    {
        $this->stocks [] = $stock;
    }

    public function get(): array
    {
        return $this->stocks;
    }
}