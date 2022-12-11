<?php

namespace App\Services;

use App\Models\Collection\StockCollection;
use App\Models\StockProfile;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class StockControllerService
{
    public function execute(string $search)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $client = new DefaultApi(
            new Client(),
            $config
        );

        $companyInfo = $client->companyProfile2($search);
        $stockPrice = $client->quote($search);

        $stockCollection = new StockCollection();
        $stockCollection->add(new StockProfile(
            $companyInfo->getName(),
            $companyInfo->getLogo(),
            $search,
            $stockPrice->getC(),
            $stockPrice->getH(),
            $stockPrice->getL(),
            $stockPrice->getDp()
        ));

        return $stockCollection;
    }
}