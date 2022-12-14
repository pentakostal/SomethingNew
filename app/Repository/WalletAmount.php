<?php

namespace App\Repository;

use App\Database;

class WalletAmount
{
    public function getMoney(): float
    {
        $dbConnection = Database::getConnection();

        $sql = "SELECT wallet FROM users WHERE id = :id";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $_SESSION["userId"]);
        $resultSet = $stmt->executeQuery();
        $users = $resultSet->fetchAllAssociative();

        $money = (float) $users[0]["wallet"];
        return $money;
    }
}