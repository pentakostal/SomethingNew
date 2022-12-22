<?php

namespace App\Repository;

use App\Database;

class WalletActions
{
    public function getMoney(): float
    {
        $dbConnection = Database::getConnection();

        $sql = "SELECT wallet FROM users WHERE id = :id";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $_SESSION["userId"]);
        $resultSet = $stmt->executeQuery();
        $users = $resultSet->fetchAllAssociative();

        $money = (float)$users[0]["wallet"];

        return $money;
    }

    public function buy(float $price, int $amount): float
    {
        $wallet = (new WalletActions())->getMoney();

        return $wallet - ($price * $amount);
    }

    public function sell(float $price, int $amount): float
    {
        $wallet = (new WalletActions())->getMoney();

        return $wallet + ($price * $amount);
    }

    public function update(float $moneyAmount, int $id): void
    {
        $dbConnection = Database::getConnection();
        $dbConnection->update("users", ["wallet" => $moneyAmount], ["id" => $id]);
    }
}