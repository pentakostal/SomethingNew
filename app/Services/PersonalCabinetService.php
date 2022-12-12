<?php

namespace App\Services;

use App\Database;
use App\Models\Wallet;

class PersonalCabinetService
{
    public function getWallet(): Wallet
    {
        $this->dbConnection = Database::getConnection();

        $sql = "SELECT wallet FROM users WHERE id = :id";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindValue("id", $_SESSION["userId"]);
        $resultSet = $stmt->executeQuery();
        $users = $resultSet->fetchAllAssociative();

        $money = (float) $users[0]["wallet"];
        $wallet = new Wallet($money);

        return $wallet;
    }
}