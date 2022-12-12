<?php

namespace App\Services;

use App\Models\Collection\StockCollection;
use App\Models\StockProfile;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class StockControllerService
{
    public function execute(array $search): StockCollection
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $client = new DefaultApi(
            new Client(),
            $config
        );
        $stockCollection = new StockCollection();
        foreach ($search as &$searched) {
            $companyInfo = $client->companyProfile2($searched);
            $stockPrice = $client->quote($searched);

            $stockCollection->add(new StockProfile(
                $companyInfo->getName(),
                $companyInfo->getLogo(),
                $searched,
                $stockPrice->getC(),
                $stockPrice->getH(),
                $stockPrice->getL(),
                $stockPrice->getDp()
            ));
        }
        return $stockCollection;
    }
}