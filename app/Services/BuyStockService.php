<?php

namespace App\Services;

use App\Database;
use App\Repository\StockBankCheck;
use App\Repository\StockPriceNow;
use App\Repository\TransactionHistoryRecord;
use App\Repository\WalletActions;

class BuyStockService
{
    public function execute(BuySellStockRequest $request): bool
    {

        $stock = (new StockPriceNow())->execute($request->getSymbol());

        $id = (int) $_SESSION["userId"];

        $moneyInWallet = (new WalletActions)->getMoney();

        if ($moneyInWallet >= $stock->getCurrentPrice() * $request->getAmount()) {
            (new TransactionHistoryRecord())->write(
                $id,
                $request->getAmount(),
                $stock->getCurrentPrice(),
                $stock->getSymbol(),
                $stock->getName(),
                "buy"
            );

            $dbConnection = Database::getConnection();

            $userStockBank = new StockBankCheck($id, $stock->getSymbol());
            if ($userStockBank->checkBank()==0) {
                $dbConnection->insert('stock_bank', [
                    "user_id" => $id,
                    "symbol" => $stock->getSymbol(),
                    "amount" => $request->getAmount()
                ]);
            } else {
                $oldStockAmount = $userStockBank->checkBank();
                $newStockAmount = $request->getAmount() + $oldStockAmount;

                $dbConnection->update('stock_bank',
                    ["amount" => $newStockAmount],
                    ["user_id" => $id,
                    "symbol" => $stock->getSymbol()]
                );
            }

            $moneyAmount = (new WalletActions())->buy($stock->getCurrentPrice(), $request->getAmount());
            (new WalletActions())->update($moneyAmount, $id);

            return true;
        }

        return false;
    }
}