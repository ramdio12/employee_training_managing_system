<?php


include 'utilities/Utilities.php';
include 'User/UserController.php';

$userContr = new UserController;
$util = new Utilities;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = Utilities::sanitizeInput($_POST["username"]);
    $password = Utilities::sanitizeInput($_POST["password"]);
    $confirm_password = Utilities::sanitizeInput($_POST["confirm_password"]);
    $role = Utilities::sanitizeInput($_POST["role"]);

    $userCheck = $userContr->isUserExist($username);


    $emptyErrors = $usernameError = $passwordError =  $confirm_passwordError = "";

    try {
        if ($util->isEmpty($username) && $util->isEmpty($password) && $util->isEmpty($confirm_password)) {
            $emptyErrors = "Please fill all the fields!";
            header('Location: registerUser.php');
        }
        if ($userContr->passwordError($password)) {
            $passwordError = "Password must have at least 8 characters with Uppercase,lowercase and special characters ";
            header('Location: registerUser.php');
        }
        if ($password !== $confirm_password) {
            $confirm_passwordError = "Passwords does not matched!";
            header('Location: registerUser.php');
        }
        if ($userCheck) {
            $usernameError = "Username is already taken";
            header('Location: registerUser.php');
        }


        if (empty($emptyErrors) && empty($usernameError) && empty($passwordError) && empty($confirm_passwordError)) {
            // $options = ['cost' => 12];
            // $hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);
            $userContr->create_user($username, $role, $password);
            header("location: users.php?message=success");
        }
    } catch (PDOException $e) {
        echo "Query failed " . $e->getMessage();
    }
}


?>

<?php include_once 'component/header.php'; ?>

<h1 class="text-center mt-5">Register</h1>
<div class="container">

    <form class="w-50 mx-auto" action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">

        <div class="mb-3">
            <label class="form-label " for="username">Username</label>
            <input class="form-control shadow-sm p-3" name="username" type="text" id="username">
            <?php if (isset($usernameError)) : ?>
                <p class="text-danger"><?= $usernameError; ?></p>
            <?php endif ?>
        </div>
        <div class="mb-3">
            <label class="form-label " for="password">Password</label>
            <input class="form-control shadow-sm p-3" name="password" type="password" id="password">
            <?php if (isset($passwordError)) : ?>
                <p class="text-danger"><?= $passwordError; ?></p>
            <?php endif ?>
        </div>
        <div class="mb-3">
            <label class="form-label " for="confirm_password">Confirm Password</label>
            <input class="form-control shadow-sm p-3" name="confirm_password" type="password" id="confirm_password">
            <?php if (isset($confirm_passwordError)) : ?>
                <p class="text-danger"><?= $confirm_passwordError; ?></p>
            <?php endif ?>

        </div>
        <div class="mb-3">
            <label class="form-label " for="role">Role</label>
            <select name="role" id="role" class="form-select shadow-sm p-3">
                <option value="admin">Admin</option>
                <option value="user">User</option>

            </select>
        </div>
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


<?php include_once 'component/footer.php'; ?>