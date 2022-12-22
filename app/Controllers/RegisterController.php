<?php

namespace App\Controllers;

use App\Services\RegistrationService;
use App\Services\RegistrationServiceRequest;
use App\Template;

class RegisterController
{
    public function showRegistrationForm(): Template
    {
        return new Template('register/register.twig');
    }

    public function storeRegistrationForm(): Template
    {
        $registerService = new RegistrationService();
        if($registerService->execute(
            new RegistrationServiceRequest(
                $_POST["name"],
                $_POST["email"],
                $_POST["password"],
                $_POST["psw-repeat"]
            )
        )){
            return new Template('register/register.twig',
            [
                'status' => 'registration ok'
            ]
            );
        }

        return new Template('register/register.twig',
            [
                'status' => 'registration failed'
            ]
        );
    }
}