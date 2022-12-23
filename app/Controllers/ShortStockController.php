<?php

namespace App\Controllers;

use App\Models\Collection\UserBankShortCollection;
use App\Services\BuySellStockRequest;
use App\Services\BuyShortStockRequest;
use App\Services\ShortBuyService;
use App\Services\ShortSellService;
use App\Template;
use function DI\string;

class ShortStockController
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
        $sellShort = new ShortSellService();

        $sellShort->execute(new BuySellStockRequest(
            $_POST["sellStockShort"],
            $_POST["sellStockAmountShort"]
        ));

        return $this->index();
    }

    public function shortBuy(): Template
    {
        $shortBuy = new ShortBuyService();
        $shortBank = new UserBankShortCollection();

        if($shortBuy->execute(new BuyShortStockRequest(
            $_POST["transactionId"],
            $_POST["buyStockAmountShort"]
        ))) {
            return new Template(
                'shortOperations/short.twig',
                [
                    "stockBankshort" => $shortBank->getUserBankStockCollection(),
                    "profit" => "Your transaction profit: ".$shortBuy->getProfit()
                ]
            );
        }

        return new Template(
            'shortOperations/short.twig',
            [
                "stockBankshort" => $shortBank->getUserBankStockCollection(),
                "profit" => "transaction failed"
            ]
        );
    }
}