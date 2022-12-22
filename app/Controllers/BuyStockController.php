<?php

namespace App\Controllers;


use App\Database;
use App\Services\BuySellStockRequest;
use App\Services\BuyStockService;
use App\Services\StockControllerService;
use App\Template;

class BuyStockController
{
    public function buyStock(): Template
    {
        $buyStock = new BuyStockService();

        $search = ["ATVI", "EA", "RBLX", "TTWO", "ZNGA", "SCPL", "CCOEF", "MYPS", "SKLZ", "DICE"];

        $stock = (new StockControllerService())->execute($search);

        if($buyStock->execute(
            new BuySellStockRequest(
                $_POST["buyStock"],
                $_POST["buyStockAmount"]
            )
        )){
            return new Template(
                'stocks/index.twig',
                [
                    'stocks' => $stock->get(),
                    'status' => "buy ok"
                ]
            );
        }

        return new Template(
            'stocks/index.twig',
            [
                'stocks' => $stock->get(),
                'status' => "buy failed"
            ]
        );
    }
}