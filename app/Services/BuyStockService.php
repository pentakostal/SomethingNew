<?php

namespace App\Services;

use App\Models\StockProfile;
use App\Repository\WalletAmount;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class BuyStockService
{
    public function execute(BuyStockRequest $request): bool
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $client = new DefaultApi(
            new Client(),
            $config
        );

        $companyInfo = $client->companyProfile2($request->getSymbol());
        $stockPrice = $client->quote($request->getSymbol());

        $buyStock = new StockProfile(
            $companyInfo->getName(),
            null,
            $request->getSymbol(),
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

        if ($moneyInWallet >= $purchasePrice * $request->getAmount()) {
            return true;
        }

        return false;
    }
}