<?php


session_start();

include_once 'utilities/Utilities.php';
include_once 'Employees/EmployeesModel.php';
include_once 'Employees/EmployeesController.php';


$employeesModel = new EmployeesModel;
$employeesContr = new EmployeesController;
$util = new Utilities;

if (isset($_GET['id'])) {
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            $id = Utilities::sanitizeInput($_GET["id"]);
            $row = $employeesModel->getEmployeeData($id);
            break;
        case 'POST':
            $id = Utilities::sanitizeInput($_POST["employee_id"]);
            $employeename = Utilities::sanitizeInput($_POST["name"]);
            $position = Utilities::sanitizeInput($_POST["position"]);

            $emptyError = "";
            try {

                if ($util->isEmpty($employeename) && $util->isEmpty($position)) {
                    $emptyErrors = "Please fill the empty fields";
                }

                if (empty($emptyError)) {
                    $employeesContr->updateEmployeeById($id, $employeename, $position);
                    header("location: employees.php");
                }
            } catch (PDOException $e) {
                echo "Query failed " . $e->getMessage();
            }
            break;

        default:
            break;
    }
} else {
    header('Location: views/error.php?message=emp_id_error');
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= $row['employee_name']; ?></title>
    <?php include_once 'component/links.php'; ?>
</head>

<body>
    <?php include_once 'component/nav.php'; ?>


    <div class="container mt-5">
        <h1 class="text-center">Edit <?= $row['employee_name']; ?></h1>

        <div class="trainingformdiv">
            <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Employee Name</label>
                    <input type="text" class="form-control shadow-sm p-3" id="name" name="name" value="<?= $row['employee_name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Employee Position</label>
                    <input type="text" class="form-control shadow-sm p-3" id="position" name="position" value="<?= $row['position']; ?>">
                </div>

                <input type="hidden" value="<?= $row['employee_id']; ?>" name="employee_id">

                <div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

                <?php if (isset($emptyErrors)) : ?>
                    <p><?= $emptyErrors; ?></p>
                <?php endif ?>
            </form>
        </div>
    </div>

</body>

</html>