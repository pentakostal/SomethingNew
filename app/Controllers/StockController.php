<?php

namespace App\Controllers;

use App\Services\StockControllerService;
use App\Template;

class StockController
{
    public function index()
    {
        $search = "CCOEF";

        $stock = (new StockControllerService())->execute($search);
        echo "<pre>";

        return new Template(
            'stocks/index.twig',
            [
                'stocks' => $stock->get()
            ]
        );

    }
}