<?php

namespace App\Controllers;

use App\Models\Collection\StockCollection;
use App\Models\StockProfile;
use App\Redirect;
use App\Repository\WalletAmount;
use App\Services\BuyStockRequest;
use App\Services\BuyStockService;
use App\Services\LogInService;
use App\Services\LogInserviceRequest;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

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