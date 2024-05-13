<?php
session_start();

include_once 'utilities/Utilities.php';
include_once 'Employees/EmployeesController.php';



$employeeContr = new EmployeesController;
$util = new Utilities;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $employeename = Utilities::sanitizeInput($_POST["name"]);
    $position = Utilities::sanitizeInput($_POST["position"]);
    $user_id = Utilities::sanitizeInput($_POST["user_id"]);


    try {
        $emptyError = "";
        if ($util->isEmpty($employeename) && $util->isEmpty($position)) {
            $emptyError = "Please fill the empty fields";
            header("location: createEmployee.php");
        } else {
            if (empty($emptyError)) {
                $employeeContr->createEmployee($employeename, $position, $user_id);
                header("location: employees.php");
            }
        }
    } catch (PDOException $e) {
        echo "Query failed " . $e->getMessage();
    }
}
?>



<?php include_once 'component/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Add Employee</h1>

    <div class="">
        <form class="w-50 mx-auto" action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Employee Name</label>
                <input type="text" class="form-control shadow-sm p-3" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Employee Position</label>
                <input type="text" class="form-control shadow-sm p-3" id="position" name="position">
            </div>
            <!-- <div class="mb-3">
                    <label for="department" class="form-label ">Department</label>
                    <select name="department" id="department" class="form-select shadow-sm p-3">
                        <option value="preparation">Preparation</option>
                        <option value="cannery">Cannery</option>
                        <option value="human resource">Human Resource</option>
                        <option value="engineering">Engineering</option>
                        <option value="papaya operation">Papaya Operation</option>
                    </select>
                </div> -->
            <!-- <div class="mb-3">
                    <label for="position" class="form-label ">Postion</label>
                    <select name="position" id="position" class="form-select shadow-sm p-3">
                        <option value="senior manager">Senior Manager</option>
                        <option value="manger">Manager</option>
                        <option value="supervisor">supervisor</option>
                        <option value="filler">Filler</option>
                    </select>
                </div> -->

            <input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="user_id">

            <div>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>

            <?php if (isset($emptyError)) : ?>
                <p><?= $emptyError; ?></p>
            <?php endif ?>
        </form>
    </div>
</div>

<?php include_once 'component/footer.php'; ?>