<?php

namespace App\Services;

use App\Database;
use App\Repository\StockPriceNow;
use App\Repository\TransactionHistoryRecord;
use App\Repository\WalletActions;

class SellStockService
{
    public function execute(BuySellStockRequest $request): bool
    {
        $stock = (new StockPriceNow())->execute($request->getSymbol());

        $id = (int) $_SESSION["userId"];
        $symbol = $stock->getSymbol();
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
                    ["user_id" => $id,
                    "symbol" => $symbol]
                );
            } elseif($newStockAmount == 0) {
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