<?php

namespace App\Services;

use App\Database;
use App\Repository\StockBankCheck;
use App\Repository\StockPriceNow;
use App\Repository\TransactionHistoryRecord;
use App\Repository\WalletActions;

class BuyStockService
{
    public function execute(BuyStockRequest $request): bool
    {

        $stock = (new StockPriceNow())->execute($request->getSymbol());

        $id = (int) $_SESSION["userId"];
        $symbol = $stock->getSymbol();
        $purchasePrice = $stock->getCurrentPrice();

        $moneyInWallet = (new WalletActions)->getMoney();

        if ($moneyInWallet >= $purchasePrice * $request->getAmount()) {
            (new TransactionHistoryRecord())->write(
                $id,
                $request->getAmount(),
                $stock->getCurrentPrice(),
                $stock->getSymbol(),
                $stock->getName(),
                "buy"
            );

            $dbConnection = Database::getConnection();

            $userStockBank = new StockBankCheck($id, $symbol);
            if ($userStockBank->checkBank()==0) {
                $dbConnection->insert('stock_bank', [
                    "user_id" => $id,
                    "symbol" => $symbol,
                    "amount" => $request->getAmount()
                ]);
            } else {
                $oldStockAmount = $userStockBank->checkBank();
                $newStockAmount = $request->getAmount() + $oldStockAmount;
                var_dump($newStockAmount);
                $dbConnection->update('stock_bank',
                    ["amount" => $newStockAmount],
                    ["user_id" => $id],
                    ["symbol" => $symbol]
                );
            }

            $moneyAmount = (new WalletActions())->buy($stock->getCurrentPrice(), $request->getAmount());
            (new WalletActions())->update($moneyAmount, $id);

            return true;
        }

        return false;
    }
}