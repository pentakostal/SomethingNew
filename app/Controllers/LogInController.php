<?php

namespace App\Controllers;

use App\Template;

class LogInController
{
    public function showLogInForm(): Template
    {
        return new Template('logIn/logIn.twig');
    }
}