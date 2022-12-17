<?php

namespace App\Models\Collection;

use App\Database;
use App\Models\UserStockBank;

class UserBankCollection
{
    private array $userBankCollection = [];

    public function __construct(array $userBankCollection = [])
    {
        $dbConnection = Database::getConnection();

        $sql = "SELECT * FROM stock_bank WHERE user_id = :user_id";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("user_id", $_SESSION["userId"]);
        $resultSet = $stmt->executeQuery();
        $records = $resultSet->fetchAllAssociative();

        for ($i = 0; $i < count($records); $i++) {
            $this->userBankCollection[] = new UserStockBank(
                $records[$i]["symbol"],
                (int) $records[$i]["amount"]
            );
        }
    }

    public function getUserBankStockCollection(): array
    {
        return $this->userBankCollection;
    }
}