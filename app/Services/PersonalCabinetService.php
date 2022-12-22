<?php

namespace App\Services;

use App\Models\Collection\UserBankCollection;
use App\Models\Collection\UserTransaction;
use App\Models\Wallet;
use App\Repository\WalletActions;

class PersonalCabinetService
{
    public function getWallet(): float
    {
        $money = (new WalletActions)->getMoney();

        return $money;
    }

    public function getTransactionRecord(): array
    {
        $transactionCollection = new UserTransaction();
        //echo "<pre>";
        //var_dump($transactionCollection->getRecordSet());
        return $transactionCollection->getRecordSet();
    }

    public function getUserStockBankCollection(): array
    {
        $getUserStockBankCollection = new UserBankCollection();
        return $getUserStockBankCollection->getUserBankStockCollection();
    }
}