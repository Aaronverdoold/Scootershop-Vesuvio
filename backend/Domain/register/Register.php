<?php
require_once __DIR__ . '/../../Presentation/register/RegisterController.php';
require_once __DIR__ . '/../../Domain/Personeel.php';

use Domain\Personeel;
use Presentation\register\RegisterController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function checkLength($value, $min, $max, $field) {
        if (strlen($value) < $min || strlen($value) > $max) {
            exit("$field must be between $min and $max characters.");
        }
        return $value;
    }

    $firstname = checkLength($_POST['firstname'], 2, 50, "Firstname");
    $lastname  = checkLength($_POST['lastname'], 2, 50, "Lastname");
    $username  = checkLength($_POST['username'], 3, 30, "Username");
    $password  = checkLength($_POST['password'], 6, 50, "Password");

    $user = new Personeel(
        null,
        $firstname,
        $lastname,
        $_POST['address'],
        $_POST['city'],
        $username,
        $password,
        $_POST['role']
    );

    $controller = new RegisterController();
    echo $controller->register($user);
}
