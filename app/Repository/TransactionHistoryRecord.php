<?php

namespace App\Repository;

use App\Database;
use Carbon\Carbon;

class TransactionHistoryRecord
{
    public function write(string $id, int $amount, float $price, string $symbol, string $companyName, string $status):void
    {
        $dbConnection = Database::getConnection();

        $dbConnection->insert("buy_history", [
            "user_id" => $id,
            "amount" => $amount,
            "price" => $price,
            "symbol" => $symbol,
            "company_name" => $companyName,
            "status" => $status,
            "date" => Carbon::now()->toDateTimeString()
        ]);
    }
}