<?php

namespace App\Services;

use App\Database;
use App\Models\StockProfile;
use App\Repository\StockPriceNow;
use App\Repository\TransactionHistoryRecord;
use App\Repository\WalletActions;
use Carbon\Carbon;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class SellStockService
{
    public function execute(SellStockRequest $request): bool
    {
        $stock = (new StockPriceNow())->execute($request->getSymbol());

        $id = $_SESSION["userId"];
        $symbol = $stock->getSymbol();
        $sellPrice = $stock->getCurrentPrice();
        $amount = $request->getAmount();

        $dbConnection = Database::getConnection();

        $sql = "SELECT * FROM stock_bank WHERE user_id = :id AND symbol = :symbol";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->bindValue("symbol", $symbol);
        $resultSet = $stmt->executeQuery();
        $user = $resultSet->fetchAllAssociative();

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

            (new TransactionHistoryRecord())->write(
                $id,
                $request->getAmount(),
                $stock->getCurrentPrice(),
                $stock->getSymbol(),
                $stock->getName(),
                "sell"
            );

            $moneyAmount = (new WalletActions())->sell($stock->getCurrentPrice(), $request->getAmount());
            (new WalletActions())->update($moneyAmount, $id);

            return true;
        }

        return false;
    }
}