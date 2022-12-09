<?php

namespace App\Services;

use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class StockControllerService
{
    public function execute()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $client = new DefaultApi(
            new Client(),
            $config
        );

        print_r($client->filings($symbol = "AAPL", $from = "2020-01-01", $to = "2020-06-11"));
    }
}