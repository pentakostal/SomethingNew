<?php

namespace App\Controllers;

use App\Template;

class StockController
{
    public function index(): Template
    {
        return new Template("stocks/index.twig");
    }
}