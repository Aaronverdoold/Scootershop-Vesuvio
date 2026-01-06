<?php

namespace Infrastructure;

use Exception;
use PDO;
use PDOException;

class DbalLogin
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUser($user)
    {
        $sql = "SELECT username, password, role FROM personeel WHERE username = :username";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':username' => $user->username]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            if (!isset($user->password) || !password_verify($user->password, $row['password'])) {
                return null;
            }

            return [
                'username' => $row['username'],
                'role' => $row['role']
            ];
        } catch (PDOException $e) {
            throw new Exception('Error fetching user: ' . $e->getMessage(), 0, $e);
        }
    }
}
