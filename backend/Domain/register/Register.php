<?php
require_once __DIR__ . '/../../Presentation/user/UserController.php';
require_once __DIR__ . '/../../Domain/Personeel.php';

use Domain\Personeel;
use Presentation\user\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = new Personeel(
        null,
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['address'],
        $_POST['city'],
        $_POST['username'],
        $_POST['password'],
        $_POST['role']
    );

    $controller = new UserController();
    echo $controller->register($user);
}
