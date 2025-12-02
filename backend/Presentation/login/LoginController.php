<?php

namespace Presentation\login;

require_once __DIR__ . '/../../Database/dbconnect.php';
require_once __DIR__ . '/../../Domain/Personeel.php';
require_once __DIR__ . '/../../Infrastructure/DbalLogin.php';
require_once __DIR__ . '/../../CustomExceptions/LoginFailedCustomException.php';

use CustomExceptions\LoginFailedCustomException;
use Database;
use Domain\Personeel;
use Infrastructure\DbalLogin;

class LoginController extends Database
{
    public function login(Personeel $user)
    {
        $pdo = $this->connect();
        $login = new DbalLogin($pdo);
        $result = $login->getUser($user);

        if (!$result) {
            throw new LoginFailedCustomException("Login failed: Invalid username or password.");
        }

        $role = $result['role'];

        switch ($role) {
            case 'management':
                header('Location: ../../../frontend/dashboard/dashboard.html');
                break;
            case 'magazijnmedewerker':
                header('Location: ../../../frontend/magazijnmedewerker.html');
                break;
            case 'verzendmedewerker':
                header('Location: ../../../frontend/verzendmedewerker.html');
                break;
            default:
               header('Location: ../../../frontend/login/login.html');
                exit;
        }

        return "Login successful. Welcome, " . htmlspecialchars($result['username']) . "!";
    }

}