<?php

namespace App\Controllers;


use App\Services\BuyStockRequest;
use App\Services\BuyStockService;

class BuyStockController
{
    public function buyStock()
    {
        $buyStock = new BuyStockService();
        if($buyStock->execute(
            new BuyStockRequest(
                $_POST["buyStock"],
                $_POST["buyStockAmount"]
            )
        )){
            var_dump("buy ok");
        } else {
            var_dump("buy failed");
        }
    }
}