<?php

namespace App\Controllers;

use App\Models\Collection\StockCollection;
use App\Models\StockProfile;
use App\Redirect;
use App\Repository\WalletAmount;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class BuyStockController
{
    public function buyStock()
    {
        $name = (string) $_POST["buyStock"];
        $amount = (int) $_POST["buyStockAmount"];

        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $client = new DefaultApi(
            new Client(),
            $config
        );

        $companyInfo = $client->companyProfile2($name);
        $stockPrice = $client->quote($name);

        $buyStock = new StockProfile(
            $companyInfo->getName(),
            null,
            $name,
            $stockPrice->getC(),
            null,
            null,
            null
        );

        $id = $_SESSION["userId"];
        $companyName = $buyStock->getName();
        $symbol = $buyStock->getSymbol();
        $purchasePrice = $buyStock->getCurrentPrice();

        $moneyInWallet = WalletAmount::getMoney();

        if ($moneyInWallet >= $purchasePrice * $amount) {
            var_dump("purchase successful");
        } else {
            var_dump("purchase not successful");
        }


        //return new Redirect('/user');
    }
}