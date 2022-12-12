<?php

namespace App\Controllers;

use App\Database;
use App\Services\PersonalCabinetService;
use App\Template;

class PersonalCabinetController
{
    public function search(): Template
    {
        return new Template(
            'personalCabinet/cabinet.twig',
        );
    }

    public function getWallet(): Template
    {
        $amount = (new PersonalCabinetService())->getWallet();

        return new Template(
            'personalCabinet/cabinet.twig',
            [
                'amount' => $amount->getAmount()
            ]
        );
    }

    public function addMoney()
    {
        $addAmount = (float) $_POST["addMoney"];
        $amount = (new PersonalCabinetService())->getWallet();

        $newAmount = $addAmount + $amount->getAmount();

        $this->dbConnection = Database::getConnection();

        $this->dbConnection->update("users", ["wallet" => $newAmount], ["id" => $_SESSION["userId"]]);

        return $this->getWallet();
    }
}