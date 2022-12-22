<?php

namespace App\Controllers;


use App\Database;
use App\Services\BuySellStockRequest;
use App\Services\BuyStockService;

class BuyStockController
{
    public function buyStock()
    {
        $buyStock = new BuyStockService();
        if($buyStock->execute(
            new BuySellStockRequest(
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