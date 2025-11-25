<?php

namespace Infrastructure;

use Exception;
use PDOException;

class DbalUser
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertUser($user)
    {
        $sql = "INSERT INTO personeel (firstname, lastname,address, city, username, password, role)
                VALUES (:firstname, :lastname, :address, :city, :username, :password, :role)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $insert = $stmt->execute([
                ':firstname' => $user->firstname,
                ':lastname' => $user->lastname,
                ':address' => $user->address,
                ':city' => $user->city,
                ':username' => $user->username,
                ':password' => password_hash($user->password, PASSWORD_BCRYPT),
                ':role' => $user->role
            ]);

            if (!$insert) {
                return false;
            }

            return true;

        } catch (PDOException $e) {
            throw new Exception('Error inserting user: ' . $e->getMessage(), 0, $e);
        }
    }
}