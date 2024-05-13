<?php
session_start();

include_once 'utilities/Utilities.php';
include_once 'Employees/EmployeesModel.php';
include_once 'Employees/EmployeesController.php';


$employeeModel = new EmployeesModel;
$employeeContr = new EmployeesController;
$util = new Utilities;

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        $rows = $employeeModel->getAllEmployees();
        break;
    case 'POST':
        $employeename = Utilities::sanitizeInput($_POST["name"]);
        $department = Utilities::sanitizeInput($_POST["department"]);
        $position = Utilities::sanitizeInput($_POST["position"]);
        $user_id = Utilities::sanitizeInput($_POST["user_id"]);

        $emptyError = "";
        try {

            if ($util->isEmpty($employeename)) {
                $emptyErrors = "Please fill the empty fields";
            }

            if (empty($emptyError)) {
                $employeeContr->createEmployee($employeename, $department, $position, $user_id);
                header("location: employees.php");
            }
        } catch (PDOException $e) {
            echo "Query failed " . $e->getMessage();
        }
        break;
        break;

    default:
        break;
}

?>

<?php include_once 'component/header.php'; ?>

<div class="container">

    <h1 class="text-center my-4">Employee Lists</h1>

    <div>
        <a href="createEmployee.php" class="btn btn-success my-2">Add Employee</a>
    </div>
    <table class="table table-dark rounded">
        <thead>
            <tr>
                <th>No.</th>
                <th>Employee Name</th>
                <th>Position</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($rows) : ?>

                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td> <?php echo $row['employee_id']; ?></td>
                        <td>
                            <a class="text-decoration-none fw-bold text-light link-danger" href="showParticipantData.php?name=<?= $row['employee_name']; ?>">
                                <?php echo ucwords(htmlspecialchars($row['employee_name'])); ?>
                            </a>
                        </td>
                        <td> <?php echo ucwords(htmlspecialchars($row['position'])); ?></td>

                        <td><?php echo ucwords(htmlspecialchars($row['user_name'])); ?></td>
                        <td>
                            <a href="editEmployee.php?id=<?= $row['employee_id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                            <a href="deleteEmployee.php?id=<?= $row['employee_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else : ?>

                html code to run if condition is false

            <?php endif ?>
        </tbody>
    </table>
</div>

<?php include_once 'component/footer.php'; ?>