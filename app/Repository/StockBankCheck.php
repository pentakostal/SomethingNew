<?php

namespace App\Repository;

use App\Database;

class StockBankCheck
{
    private string $symbol;
    private string $id;

    public function __construct(string $id, string $symbol)
    {
        $this->id = $id;
        $this->symbol = $symbol;
    }

    public function checkBank(): int
    {
        $dbConnection = Database::getConnection();
        $sql = "SELECT * FROM stock_bank WHERE user_id = :id AND symbol = :symbol";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $this->id);
        $stmt->bindValue("symbol", $this->symbol);
        $resultSet = $stmt->executeQuery();
        $stockAmount = $resultSet->fetchAllAssociative();

        if ($stockAmount == null) {
            return 0;
        }
        return (int) $stockAmount[0]["amount"];
    }
}