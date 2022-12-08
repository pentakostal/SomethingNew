<?php

namespace App\Services;

use App\Database;
use Doctrine\DBAL\DriverManager;

require_once 'vendor/autoload.php';

class RegistrationService
{
    private $dbConnection;

    public function execute(RegistrationServiceRequest $request)
    {
        $this->dbConnection = Database::getConnection();
        $newUser = $request;

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindValue("email", $newUser->getEmail());
        $resultSet = $stmt->executeQuery();
        $users = $resultSet->fetchAllAssociative();

        if ($users == null && $newUser->getPassword() == $newUser->getPasswordRepeat()) {
            $this->dbConnection->insert('users', [
                "name" => $newUser->getName(),
                "email" => $newUser->getEmail(),
                "password" => password_hash($newUser->getPassword(), PASSWORD_DEFAULT)
            ]);
            return true;
        }
        return false;
    }
}