<?php

namespace App\Controllers;

use App\Database;
use App\Models\Collection\UserTransaction;
use App\Services\PersonalCabinetService;
use App\Template;

class PersonalCabinetController
{
    public function getPersonalCabinet(): Template
    {
        $amount = new PersonalCabinetService();

        return new Template(
            'personalCabinet/cabinet.twig',
            [
                'amount' => $amount->getWallet(),
                'records' => $amount->getTransactionRecord(),
                'stockBank' => $amount->getUserStockBankCollection()
            ]
        );
    }

    public function addMoney()
    {
        $addAmount = (float) $_POST["addMoney"];
        $amount = (new PersonalCabinetService())->getWallet();

        $newAmount = $addAmount + $amount;

        $this->dbConnection = Database::getConnection();

        $this->dbConnection->update("users", ["wallet" => $newAmount], ["id" => $_SESSION["userId"]]);

        return $this->getPersonalCabinet();
    }
}