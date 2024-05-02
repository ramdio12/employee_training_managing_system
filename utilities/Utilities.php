<?php


class Utilities
{
    // sanitize input values
    public static function sanitizeInput($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = stripslashes($input);
        return $input;
    }

    public static function sessionCheck()
    {
        // Initialize the session
        session_start();

        // Check if the user is already logged in, if yes then redirect him to welcome page
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: dashboard.php");
            exit;
        }
    }

    public function isEmpty($input)
    {
        if (empty($input)) {
            return true;
        } else {
            return false;
        }
    }
}
