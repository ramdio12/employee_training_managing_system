<?php

include 'utilities/Utilities.php';
require_once 'User/UserModel.php';
include 'User/UserController.php';


Utilities::sessionCheck();

$model = new UserModel;
$userContr = new UserController;
$util = new Utilities;


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $username = Utilities::sanitizeInput($_POST["username"]);
    $password = Utilities::sanitizeInput($_POST["password"]);

    $usernameError = $passwordError = $emptyAndCredentialError = "";
    try {
        if ($util->isEmpty($username) && $util->isEmpty($password)) {
            $emptyInputError = "Please fill all the fields!";
        }

        if (empty($usernameError) && empty($passwordError) && empty($emptyAndCredentialError)) {
            $result = $model->login($username, $password);
            if ($result) {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $result["user_id"];
                $_SESSION["user_username"] = htmlspecialchars($result["user_name"]);
                $_SESSION["user_role"] = htmlspecialchars($result["user_role"]);
                header("Location: dashboard.php?login=success");
            }
        }

        // if ($userContr->isUserNotFound($result)) {
        //     $credentialError = "Incorrect credential!";
        // } else if (!$userContr->isUserNotFound($result) && $userContr->isPasswordWrong($password, $result["password"])) {
        //     $credentialError = "Incorrect credential!";
        // } else {
        //     session_start();
        //     $_SESSION["loggedin"] = true;
        //     $_SESSION["user_id"] = $result["id"];
        //     $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        //     $_SESSION["user_role"] = htmlspecialchars($result["role"]);
        //     header("Location: dashboard.php?login=success");
        // }
    } catch (PDOException $e) {
        echo "Query failed " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php
    include_once 'component/links.php';
    ?>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center flex-column w-100">

        <h1 class="my-5">Employee Training Management System</h1>

        <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST" class="border border-black rounded p-4 w-25 mt-4 bg-dark text-white">
            <h1 class="text-center my-2">Login</h1>
            <div class="my-3">
                <label for="username" class="form-label fw-bold">Username</label>
                <input name="username" type="text" id="username" class="form-control py-2 shadow-sm">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input name="password" type="password" id="password" class="form-control py-2 shadow-sm">
            </div>
            <button type="submit" class="btn btn-primary my-4 mx-auto">Submit</button>
            <?php if (isset($emptyAndCredentialError)) : ?>
                <p><?= $emptyAndCredentialError; ?></p>
            <?php endif ?>

        </form>
    </div>

</body>

</html>