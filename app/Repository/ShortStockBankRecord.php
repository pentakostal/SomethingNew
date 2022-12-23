<?php

namespace App\Repository;

use App\Database;
use App\Models\ShortStock;

class ShortStockBankRecord
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function findRecord(): ShortStock
    {
        $dbConnection = Database::getConnection();
        $sql = "SELECT * FROM stock_bank_short WHERE transaction_id = :id";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $this->id);
        $resultSet = $stmt->executeQuery();
        $stockAmount = $resultSet->fetchAllAssociative();

        $transaction = new ShortStock(
            (int) $stockAmount[0]["transaction_id"],
            (int) $stockAmount[0]["user_id"],
            $stockAmount[0]["symbol"],
            (float) $stockAmount[0]["price"],
            (int) $stockAmount[0]["amount"],
        );

        return $transaction;
    }
}