<?php

namespace App\Models\Collection;

use App\Database;
use App\Models\RecordHistory;

class userTransaction
{
    private array $recordSet = [];

    public function __construct(array $recordSet = [])
    {
        $dbConnection = Database::getConnection();

        $sql = "SELECT * FROM buy_history WHERE user_id = :user_id ORDER BY date DESC LIMIT 5";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("user_id", $_SESSION["userId"]);
        $resultSet = $stmt->executeQuery();
        $records = $resultSet->fetchAllAssociative();

        for ($i = 0; $i < count($records); $i++) {
            $this->recordSet[] = new RecordHistory(
                (int) $records[$i]["buy_id"],
                (int) $records[$i]["amount"],
                (float) $records[$i]["price"],
                $records[$i]["symbol"],
                $records[$i]["status"],
                $records[$i]["date"]
            );
        }
    }

    public function getRecord()
    {
        $dbConnection = Database::getConnection();

        $sql = "SELECT * FROM buy_history WHERE user_id = :user_id ORDER BY date DESC";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("user_id", $_SESSION["userId"]);
        $resultSet = $stmt->executeQuery();
        $records = $resultSet->fetchAllAssociative();

        for ($i = 0; $i < count($records); $i++) {
            $this->recordSet[] = new RecordHistory(
                (int) $records[$i]["buy_id"],
                (int) $records[$i]["amount"],
                (float) $records[$i]["price"],
                $records[$i]["symbol"],
                $records[$i]["status"],
                $records[$i]["date"]
            );
        }
    }

    public function getRecordSet(): array
    {
        return $this->recordSet;
    }
}