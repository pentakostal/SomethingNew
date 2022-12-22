<?php

namespace App\Repository;

use App\Models\StockProfile;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class StockPriceNow
{
    public function execute(string $symbol): StockProfile
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $client = new DefaultApi(
            new Client(),
            $config
        );

        $companyInfo = $client->companyProfile2($symbol);
        $stockPrice = $client->quote($symbol);

        $stock = new StockProfile(
            $companyInfo->getName(),
            null,
            $symbol,
            $stockPrice->getC(),
            null,
            null,
            null
        );

        return $stock;
    }
}