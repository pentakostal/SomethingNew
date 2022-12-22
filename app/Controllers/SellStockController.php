<?php

namespace App\Controllers;

use App\Services\BuySellStockRequest;
use App\Services\PersonalCabinetService;
use App\Services\SellStockService;
use App\Template;

class SellStockController
{
    public function sellStock(): Template
    {
        $sellStock = new SellStockService();

        $amount = new PersonalCabinetService();

        if($sellStock->execute(
            new BuySellStockRequest(
                $_POST["sellStock"],
                $_POST["sellStockAmount"]
            )
        )){
            return new Template(
                'personalCabinet/cabinet.twig',
                [
                    'amount' => $amount->getWallet(),
                    'records' => $amount->getTransactionRecord(),
                    'stockBank' => $amount->getUserStockBankCollection(),
                    'status' => 'sell ok'
                ]
            );
        } return new Template(
        'personalCabinet/cabinet.twig',
        [
            'amount' => $amount->getWallet(),
            'records' => $amount->getTransactionRecord(),
            'stockBank' => $amount->getUserStockBankCollection(),
            'status' => 'sell ffailed'
        ]
    );
    }
}