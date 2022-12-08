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

    public function storeRegistrationForm()
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
            var_dump("registration OK");
        } else {
            var_dump("registration FAILED");
        }
    }
}