<?php

namespace App\Services;

use App\Database;
use App\Repository\ShortStockBankRecord;
use App\Repository\StockPriceNow;
use App\Repository\TransactionHistoryRecord;
use App\Repository\WalletActions;

class ShortBuyService
{
    /**
     * @var float|int
     */
    private float $profit;

    public function execute(BuyShortStockRequest $request): bool
    {
        $record = new ShortStockBankRecord($request->getTransactionId());

        $recordObject = $record->findRecord();

        $dbConnection = Database::getConnection();

        if ($recordObject->getAmount()>$request->getAmount()) {
            $dbConnection->update('stock_bank_short',
                ["amount" => ($recordObject->getAmount() - $request->getAmount())],
                ["transaction_id" => $recordObject->getTransactionId()]
            );
        } elseif ($recordObject->getAmount()==$request->getAmount()) {
            $dbConnection->delete('stock_bank_short', ["transaction_id" => $recordObject->getTransactionId()]);
        } else {
            return false;
        }

        $price = (new StockPriceNow())->execute($recordObject->getSymbol());
        $priceSell = $recordObject->getPrice() * $request->getAmount();
        $priceBuy = $request->getAmount() * $price->getCurrentPrice();
        $shortSum = $priceSell - $priceBuy;

        $walletNew = (new WalletActions())->getMoney() + $shortSum;

        (new WalletActions())->update($walletNew, $recordObject->getUserId());

        (new TransactionHistoryRecord())->write(
            $recordObject->getUserId(),
            $request->getAmount(),
            $recordObject->getPrice(),
            $recordObject->getSymbol(),
            $recordObject->getSymbol(),
            "short buy"
        );

        $this->profit = $shortSum;

        return true;
    }
    public function getProfit(): float
    {
        return $this->profit;
    }
}