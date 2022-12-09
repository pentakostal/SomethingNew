<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\LogInService;
use App\Services\LogInserviceRequest;
use App\Template;

class LogInController
{
    public function showLogInForm(): Template
    {
        return new Template('logIn/logIn.twig');
    }

    public function logToSystem()
    {
        $logInService = new LogInService();
        if($logInService->execute(
            new LogInServiceRequest(
                $_POST["email"],
                $_POST["password"]
            )
        )){
            return new Redirect('/user');
        }
        var_dump("log NOT successful");

    }

    public function logOut(): Template
    {
        return new Template('home/home.twig');
    }
}