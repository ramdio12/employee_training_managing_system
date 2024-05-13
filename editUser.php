<?php


session_start();

include 'utilities/Utilities.php';
include 'User/UserController.php';

$userContr = new UserController;
$util = new Utilities;

if (isset($_GET['id'])) {
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {

        case 'GET':
            $id = Utilities::sanitizeInput($_GET['id']);
            if (isset($id)) {
                $result = $userContr->get_user_data($id);
            }
            break;

        case 'POST':
            $id = Utilities::sanitizeInput($_POST["id"]);
            $username = Utilities::sanitizeInput($_POST["username"]);
            $password = Utilities::sanitizeInput($_POST["password"]);
            $role = Utilities::sanitizeInput($_POST["role"]);



            $emptyErrors = $usernameError = $passwordError = "";

            try {
                if ($util->isEmpty($username) && $util->isEmpty($password) && $util->isEmpty($confirm_password)) {
                    $emptyErrors = "Please fill all the fields!";
                }
                if ($userContr->passwordError($password)) {
                    $passwordError = "Password must have at least 8 characters with Uppercase,lowercase and special characters ";
                }



                if (empty($emptyErrors) && empty($usernameError) && empty($passwordError)) {
                    $userContr->update_user($id, $username, $role, $password);
                    header("location: users.php?message=success");
                }
            } catch (PDOException $e) {
                echo "Update Error" . $e->getMessage();
            }

            break;
    }
} else {
    header('Location: views/error.php?message=user_id_error');
}






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <?php
    include_once 'component/links.php';
    ?>
</head>

<body>
    <?php
    include_once 'component/nav.php';
    ?>

    <h1 class="text-center mt-5">Edit <?= $result['user_name'] ?> </h1>
    <div class="registerform">

        <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">

            <div class="mb-3">
                <label class="form-label " for="username">Username</label>
                <input class="form-control shadow-sm p-3" name="username" type="text" id="username" value="<?= $result['user_name'] ?>">
                <?php if (isset($usernameError)) : ?>
                    <p class="text-danger"><?= $usernameError; ?></p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label class="form-label " for="password">Password</label>
                <input class="form-control shadow-sm p-3" name="password" type="password" id="password" value="<?= $result['password'] ?>">
                <?php if (isset($passwordError)) : ?>
                    <p class="text-danger"><?= $passwordError; ?></p>
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label class="form-label " for="role">Role</label>
                <select name="role" id="role" class="form-select shadow-sm p-3">
                    <option value="admin" <?php echo ($result['user_role'] === 'admin') ? 'selected="selected"' : ''; ?>>Admin</option>
                    <option value="user" <?php echo ($result['user_role'] === 'user') ? 'selected="selected"' : ''; ?>>User</option>

                </select>
            </div>
            <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id">
            <div class="my-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="users.php" class="btn btn-danger">Back</a>
            </div>

            <div>
                <?php if (isset($emptyErrors)) : ?>
                    <p class="text-danger"><?= $emptyErrors; ?></p>
                <?php endif ?>
            </div>
        </form>
    </div>


</body>

</html>