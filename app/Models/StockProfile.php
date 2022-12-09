<?php

namespace App\Models;

class StockProfile
{
    private string $name;
    private string $symbol;
    private string $logo;
    private float $currentPrice;
    private float $change;
    private float $percentChange;
    private float $highPriceOfDay;
    private float $lowPriceOfDay;
    private float $openPriceOfDay;
    private float $previousClosePrice;

    public function __construct(
        string $name,
        string $symbol,
        string $logo,
        float $currentPrice,
        float $change,
        float $percentChange,
        float $highPriceOfDay,
        float $lowPriceOfDay,
        float $openPriceOfDay,
        float $previousClosePrice
    )
    {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->logo = $logo;
        $this->currentPrice = $currentPrice;
        $this->change = $change;
        $this->percentChange = $percentChange;
        $this->highPriceOfDay = $highPriceOfDay;
        $this->lowPriceOfDay = $lowPriceOfDay;
        $this->openPriceOfDay = $openPriceOfDay;
        $this->previousClosePrice = $previousClosePrice;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    public function getChange(): float
    {
        return $this->change;
    }

    public function getPercentChange(): float
    {
        return $this->percentChange;
    }

    public function getHighPriceOfDay(): float
    {
        return $this->highPriceOfDay;
    }

    public function getLowPriceOfDay(): float
    {
        return $this->lowPriceOfDay;
    }

    public function getOpenPriceOfDay(): float
    {
        return $this->openPriceOfDay;
    }

    public function getPreviousClosePrice(): float
    {
        return $this->previousClosePrice;
    }
}