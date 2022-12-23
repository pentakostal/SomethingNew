<?php

namespace App\Services;

use App\Database;
use App\Repository\StockPriceNow;
use App\Repository\TransactionHistoryRecord;

class ShortSellService
{
    public function execute(BuySellStockRequest $request)
    {
        $stock = (new StockPriceNow())->execute($request->getSymbol());

        $id = (int) $_SESSION["userId"];

        (new TransactionHistoryRecord())->write(
            $id,
            $request->getAmount(),
            $stock->getCurrentPrice(),
            $stock->getSymbol(),
            $stock->getName(),
            "short sell"
        );

        $dbConnection = Database::getConnection();

        $dbConnection->insert('stock_bank_short', [
            "user_id" => $id,
            "symbol" => $stock->getSymbol(),
            "price" => $stock->getCurrentPrice(),
            "amount" => $request->getAmount()
        ]);

    }
}