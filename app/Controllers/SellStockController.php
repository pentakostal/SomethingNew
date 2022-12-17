<?php

namespace App\Controllers;

use App\Services\SellStockRequest;
use App\Services\SellStockService;

class SellStockController
{
    public function sellStock()
    {
        $sellStock = new SellStockService();
        if($sellStock->execute(
            new SellStockRequest(
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