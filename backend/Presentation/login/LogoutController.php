<?php

namespace Presentation\login;

use CustomExceptions\LogoutFailedCustomException;
use Exception;

class LogoutController
{
    public function logout()
    {
        try {
            session_start();
            session_unset();
            session_destroy();
        } catch (Exception $e) {
            throw new LogoutFailedCustomException("Logout failed: " . $e->getMessage());
        }

        return "Logout successful.";
    }
}
