<?php

namespace App\Controllers;

use App\Services\PersonalCabinetService;
use App\Services\TransferRequest;
use App\Services\TransferService;
use App\Template;

class TransferController
{
    public function transferStock()
    {
        $transferStock = new TransferService();

        $amount = new PersonalCabinetService();

        if($transferStock->execute(
            new TransferRequest(
                $_POST["transferStock"],
                $_POST["transferStockAmount"],
                $_POST["transferUser"],
                $_POST["password"]
            )
        )){
            return new Template(
                'personalCabinet/cabinet.twig',
                [
                    'amount' => $amount->getWallet(),
                    'records' => $amount->getTransactionRecord(),
                    'stockBank' => $amount->getUserStockBankCollection(),
                    'status' => 'transfer ok'
                ]
            );
        }

        return new Template(
            'personalCabinet/cabinet.twig',
            [
                'amount' => $amount->getWallet(),
                'records' => $amount->getTransactionRecord(),
                'stockBank' => $amount->getUserStockBankCollection(),
                'status' => 'transfer failed'
            ]
        );
    }
}