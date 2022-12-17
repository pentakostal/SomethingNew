<?php

namespace App\Controllers;

use App\Services\TransferRequest;
use App\Services\TransferService;

class TransferController
{
    public function transferStock()
    {
        $transferStock = new TransferService();
        if($transferStock->execute(
            new TransferRequest(
                $_POST["transferStock"],
                $_POST["transferStockAmount"],
                $_POST["transferUser"],
                $_POST["password"]
            )
        )){
            var_dump("transfer ok");
        } else {
            var_dump("transfer failed");
        }
    }
}