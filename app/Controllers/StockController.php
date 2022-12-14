<?php

namespace App\Controllers;

use App\Services\StockControllerService;
use App\Template;

class StockController
{
    public function index(): Template
    {
        $search = ["ATVI", "EA", "RBLX", "TTWO", "ZNGA", "SCPL", "CCOEF", "MYPS", "SKLZ", "DICE"];

        $stock = (new StockControllerService())->execute($search);
        //var_dump($_SESSION["userId"]);
        return new Template(
            'stocks/index.twig',
            [
                'stocks' => $stock->get()
            ]
        );
    }

    public function search(): Template
    {
        $search = [$_GET['search']];

        $stock = (new StockControllerService())->execute($search);

        //echo "<pre>";
        //var_dump($_GET['search']);

        return new Template(
            'stocks/index.twig',
            [
                'stocks' => $stock->get()
            ]
        );
    }
}