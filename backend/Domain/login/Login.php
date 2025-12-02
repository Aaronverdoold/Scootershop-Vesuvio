<?php
require_once __DIR__ . '/../../Domain/Personeel.php';
require_once __DIR__ . '/../../Presentation/login/LoginController.php';

use Domain\Personeel;
use Presentation\login\LoginController;
use CustomExceptions\LoginFailedCustomException;

$user = new Personeel(
    null,
    null,
    null,
    null,
    null,
    $_POST['username'],
    $_POST['password'],
    null
);

$user->username = $_POST['username'];
$user->password = $_POST['password'];

$controller = new LoginController();

try {
    $message = $controller->login($user);
    echo $message;

} catch (LoginFailedCustomException $e) {
    echo $e->getMessage();
}
