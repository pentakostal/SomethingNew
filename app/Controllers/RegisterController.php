<?php

namespace App\Controllers;

use App\Template;

class RegisterController
{
    public function showRegistrationForm(): Template
    {
        return new Template('register/register.twig');
    }
}