<?php

namespace App\Services;

use App\Database;

class LogInService
{
    public function execute(LogInServiceRequest $request): bool
    {
        $this->dbConnection = Database::getConnection();
        $logInUser = $request;

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindValue("email", $logInUser->getEmail());
        $resultSet = $stmt->executeQuery();
        $users = $resultSet->fetchAllAssociative();

        if ($users) {
            if (password_verify($logInUser->getPassword(), $users[0]["password"])) {
                $sql = "SELECT id FROM users WHERE email = :email";
                $stmt = $this->dbConnection->prepare($sql);
                $stmt->bindValue("email", $logInUser->getEmail());
                $resultSet = $stmt->executeQuery();
                $id = $resultSet->fetchAllAssociative();

                //$_SESSION["userId"]=$id[0]['id'];

                return true;
            }
        }
        return false;
    }
}