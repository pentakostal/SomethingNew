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

    public function logToSystem(): Redirect
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

        return new Redirect('/logIn');
    }

    public function logOut(): Template
    {
        session_destroy();
        return new Template('home/home.twig');
    }
}