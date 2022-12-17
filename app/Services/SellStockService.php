<?php

namespace App\Services;

use App\Database;
use App\Models\StockProfile;
use App\Repository\WalletAmount;
use Carbon\Carbon;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class SellStockService
{
    public function execute(SellStockRequest $request): bool
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
        $sellPrice = $buyStock->getCurrentPrice();
        $amount = $request->getAmount();

        $moneyInWallet = WalletAmount::getMoney();

        $dbConnection = Database::getConnection();

        $sql = "SELECT * FROM stock_bank WHERE user_id = :id AND symbol = :symbol";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->bindValue("symbol", $symbol);
        $resultSet = $stmt->executeQuery();
        $user = $resultSet->fetchAllAssociative();

        echo "<pre>";
        var_dump($user);

        if ($user != null) {
            $newStockAmount = (int) $user[0]['amount'] - $amount;
            if ($newStockAmount > 0) {
                $dbConnection->update('stock_bank',
                    ["amount" => $newStockAmount],
                    ["user_id" => $id],
                    ["symbol" => $symbol]
                );
            } else {
                $dbConnection->delete('stock_bank', ['symbol' => $symbol, 'user_id' => $id]);
            }

            $dbConnection->insert("buy_history", [
                "user_id" => $id,
                "amount" => $request->getAmount(),
                "price" => $sellPrice,
                "symbol" => $symbol,
                "company_name" => $companyName,
                "status" => "sell",
                "date" => Carbon::now()->toDateTimeString()
            ]);

            $wallet = (new \App\Repository\WalletAmount)->getMoney();
            $newAmount = $wallet - ($sellPrice * $request->getAmount());
            $dbConnection->update("users", ["wallet" => $newAmount], ["id" => $id]);

            return true;
        }

        return false;
    }
}