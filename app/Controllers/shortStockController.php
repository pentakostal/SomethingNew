<?php

namespace App\Controllers;

use App\Models\Collection\UserBankShortCollection;
use App\Services\BuySellStockRequest;
use App\Services\shortSellService;
use App\Template;

class shortStockController
{
    public function index(): Template
    {
        $shortBank = new UserBankShortCollection();

        return new Template(
            'shortOperations/short.twig',
            [
                "stockBankshort" => $shortBank->getUserBankStockCollection()
            ]
        );
    }

    public function shortSell()
    {
        $sellShort = new shortSellService();

        $sellShort->execute(new BuySellStockRequest(
            $_POST["sellStockShort"],
            $_POST["sellStockAmountShort"]
        ));

        return $this->index();
    }
}