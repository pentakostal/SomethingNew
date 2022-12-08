<?php

namespace App\Controllers;

use App\Template;

class HomeController
{
    public function index(): Template
    {
        return new Template('home/home.twig');
    }
}