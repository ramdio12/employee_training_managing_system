<?php
session_start();

include_once 'utilities/Utilities.php';
include_once 'User/UserController.php';

$trainingContr = new UserController;
$rows = $trainingContr->getUsers();

?>


<?php include_once 'component/header.php'; ?>


<div class="container">
    <h1 class="text-center my-5">HR Team Credentials</h1>
    <div>
        <div>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                <a href="registerUser.php" class="btn btn-success my-2">
                    Register new user
                </a>
            <?php else : ?>
                <h1>Only admin can edit or remove users</h1>
            <?php endif ?>
        </div>
        <div class="d-flex align-items-center justify-content-between my-2">
            <p class="fw-semibold fs-5">Current User: <?= ucwords($_SESSION['user_username']); ?></p>
            <p class="fw-semibold fs-5">Authorization: <?= ucwords($_SESSION['user_role']); ?></p>

        </div>


        <table class="table table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($rows) : ?>

                    <?php foreach ($rows as $row) : ?>

                        <tr>
                            <th> <?php echo $row['user_id']; ?></th>
                            <th><?php echo ucwords($row['user_name']); ?></th>
                            <th><?php echo ucwords($row['password']); ?></th>
                            <th><?php echo ucwords($row['user_role']); ?></th>

                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                                <th>

                                    <a href="editUser.php?id=<?= $row['user_id']; ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                    <a href="deleteUser.php?id=<?= $row['user_id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Delete</a>
                                </th>
                            <?php else : ?>
                                <th>Admin Only</th>
                            <?php endif ?>


                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>

                    html code to run if condition is false

                <?php endif ?>
            </tbody>
        </table>

    </div>
</div>

<?php include_once 'component/footer.php'; ?>