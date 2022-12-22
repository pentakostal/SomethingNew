<?php

namespace App\Services;

use App\Database;
use App\Repository\TransactionHistoryRecord;

class TransferService
{
    public function execute(TransferRequest $request): bool
    {
        $dbConnection = Database::getConnection();
        $id = $_SESSION["userId"];
        $user = $request;
        $amount = $user->getAmount();
        $symbol = $user->getSymbol();

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $id);
        $resultSet = $stmt->executeQuery();
        $users = $resultSet->fetchAllAssociative();

        $sql = "SELECT * FROM stock_bank WHERE user_id = :id AND symbol = :symbol";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->bindValue("symbol", $user->getSymbol());
        $resultStockSet = $stmt->executeQuery();
        $stocks = $resultStockSet->fetchAllAssociative();

        if ($users) {
            if (password_verify($user->getPassword(), $users[0]["password"]) &&
                $stocks[0]['amount'] >= $user->getAmount()) {

                $newStockAmount = (int) $stocks[0]['amount'] - $amount;

                if ($newStockAmount > 0) {
                    $dbConnection->update('stock_bank',
                        ["amount" => $newStockAmount],
                        ["symbol" => $symbol],
                        ["user_id" => $id]
                    );
                } else {
                    $dbConnection->delete('stock_bank', ['symbol' => $symbol, 'user_id' => $id]);
                }

                //To new user register
                $sql = "SELECT * FROM users WHERE email = :email";
                $stmt = $dbConnection->prepare($sql);
                $stmt->bindValue("email", $user->getUserTransfer());
                $resultTransferSet = $stmt->executeQuery();
                $userTransfer = $resultTransferSet->fetchAllAssociative();

                $sql = "SELECT * FROM stock_bank WHERE user_id = :id AND symbol = :symbol";
                $stmt = $dbConnection->prepare($sql);
                $stmt->bindValue("id", $userTransfer[0]['id']);
                $stmt->bindValue("symbol", $user->getSymbol());
                $transferToNewUserResault = $stmt->executeQuery();
                $transferToNewUser = $transferToNewUserResault->fetchAllAssociative();

                $newStockAmount = (int) $transferToNewUser[0]['amount'] + $amount;

                $dbConnection->update('stock_bank',
                    ["amount" => $newStockAmount],
                    ["user_id" => $userTransfer[0]['id'],
                    "symbol" => $symbol]
                );

                (new TransactionHistoryRecord())->write(
                    $id,
                    $user->getAmount(),
                    0,
                    $user->getSymbol(),
                    "--",
                    "transfer"
                );

                return true;
            }
        }

        return false;
    }
}