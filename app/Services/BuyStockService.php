<?php

namespace App\Services;

use App\Database;
use App\Models\StockProfile;
use App\Repository\StockBankCheck;
use App\Repository\StockPriceNow;
use App\Repository\TransactionHistoryRecord;
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

        $stock = (new StockPriceNow())->execute($request->getSymbol());

        $id = $_SESSION["userId"];
        $symbol = $stock->getSymbol();
        $purchasePrice = $stock->getCurrentPrice();

        $moneyInWallet = WalletAmount::getMoney();

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
                    "user_id" => (int) $id,
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

            $wallet = (new \App\Repository\WalletAmount)->getMoney();
            $newAmount = $wallet - ($purchasePrice * $request->getAmount());
            $dbConnection->update("users", ["wallet" => $newAmount], ["id" => $id]);

            return true;
        }

        return false;
    }
}