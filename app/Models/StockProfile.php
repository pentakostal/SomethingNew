<?php

namespace App\Models;

class StockProfile
{
    private ?string $name;
    private ?string $symbol;
    private ?string $logo;
    private ?float $currentPrice;
    private ?float $highPriceOfDay;
    private ?float $lowPriceOfDay;
    private ?float $percentChange;

    public function __construct(
        ?string $name = null,
        ?string $logo = null,
        ?string $symbol = null,
        ?float $currentPrice = null,
        ?float $highPriceOfDay = null,
        ?float $lowPriceOfDay = null,
        ?float $percentChange = null

    )
    {
        $this->name = $name;
        $this->logo = $logo;
        $this->symbol = $symbol;
        $this->currentPrice = $currentPrice;
        $this->highPriceOfDay = $highPriceOfDay;
        $this->lowPriceOfDay = $lowPriceOfDay;
        $this->percentChange = $percentChange;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function getCurrentPrice(): ?float
    {
        return $this->currentPrice;
    }

    public function getHighPriceOfDay(): ?float
    {
        return $this->highPriceOfDay;
    }

    public function getLowPriceOfDay(): ?float
    {
        return $this->lowPriceOfDay;
    }

    public function getPercentChange(): ?float
    {
        return $this->percentChange;
    }
}