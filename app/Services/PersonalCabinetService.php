<?php

namespace App\Services;

use App\Database;
use App\Models\Wallet;
use App\Repository\WalletAmount;

class PersonalCabinetService
{
    public function getWallet(): Wallet
    {
        $money = (new \App\Repository\WalletAmount)->getMoney();
        $wallet = new Wallet($money);

        return $wallet;
    }
}