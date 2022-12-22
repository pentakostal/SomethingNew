<?php

namespace App\Controllers;

use App\Services\BuySellStockRequest;
use App\Services\SellStockService;

class SellStockController
{
    public function sellStock()
    {
        $sellStock = new SellStockService();
        if($sellStock->execute(
            new BuySellStockRequest(
                $_POST["sellStock"],
                $_POST["sellStockAmount"]
            )
        )){
            var_dump("sell ok");
        } else {
            var_dump("sell failed");
        }
    }
}