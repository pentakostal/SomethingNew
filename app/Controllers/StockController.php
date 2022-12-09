<?php

namespace App\Controllers;

use App\Template;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class StockController
{
    public function index()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $client = new DefaultApi(
            new Client(),
            $config
        );
        echo "<pre>";

        print_r($client->quote("AAPL"));

        //return new Template("stocks/index.twig");
    }
}