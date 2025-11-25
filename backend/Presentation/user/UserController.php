<?php

namespace Presentation\user;

require_once __DIR__ . '/../../Database/dbconnect.php';
require_once __DIR__ . '/../../Domain/Personeel.php';
require_once __DIR__ . '/../../Infrastructure/DbalUser.php';
require_once __DIR__ . '/../../CustomExceptions/UserRegistrationCustomException.php';

use CustomExceptions\UserRegistrationCustomException;
use Domain\Personeel;
use Infrastructure\DbalUser;

class UserController extends \Database
{
    public function register(Personeel $user)
    {
        $db = $this->connect();
        $userRepo = new DbalUser($db);
        $result = $userRepo->insertUser($user);

        if (!$result) {
            throw new UserRegistrationCustomException("User registration failed.");
        }

        return "User registered successfully.";
    }
}
