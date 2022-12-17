<?php

namespace App\Services;

use App\Database;
use App\Models\StockProfile;
use App\Repository\WalletAmount;
use Carbon\Carbon;
use Doctrine\DBAL\Exception;
use Finnhub\Api\DefaultApi;
use Finnhub\ApiException;
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
            $dbConnection = Database::getConnection();

            $dbConnection->insert("buy_history", [
                "user_id" => $_SESSION["userId"],
                "amount" => $request->getAmount(),
                "price" => $purchasePrice,
                "symbol" => $symbol,
                "company_name" => $companyName,
                "status" => "buy",
                "date" => Carbon::now()->toDateTimeString()
            ]);

            $wallet = (new \App\Repository\WalletAmount)->getMoney();
            $newAmount = $wallet - ($purchasePrice * $request->getAmount());
            $dbConnection->update("users", ["wallet" => $newAmount], ["id" => $_SESSION["userId"]]);

            return true;
        }

        return false;
    }
}