<?php

namespace App\Models\Collection;

use App\Database;
use App\Models\UserStockBankShort;

class UserBankShortCollection
{
    private array $userBankCollection = [];

    public function __construct(array $userBankCollection = [])
    {
        $dbConnection = Database::getConnection();

        $sql = "SELECT * FROM stock_bank_short WHERE user_id = :user_id";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("user_id", $_SESSION["userId"]);
        $resultSet = $stmt->executeQuery();
        $records = $resultSet->fetchAllAssociative();

        for ($i = 0; $i < count($records); $i++) {
            $this->userBankCollection[] = new UserStockBankShort(
                (int) $records[$i]["transaction_id"],
                $records[$i]["symbol"],
                (float) $records[$i]["price"],
                (int) $records[$i]["amount"]
            );
        }
    }

    public function getUserBankStockCollection(): array
    {
        return $this->userBankCollection;
    }
}