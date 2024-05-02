<?php


session_start();

include_once 'utilities/Utilities.php';
include_once 'Proctor/ProctorModel.php';
include_once 'Proctor/ProctorController.php';


$proctorModel = new ProctorModel;
$proctorContr = new ProctorController;
$util = new Utilities;


$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        $rows = $proctorModel->getAllProctors();
        break;
    case 'POST':
        $proctorname = Utilities::sanitizeInput($_POST["proctorname"]);
        $iscompanyemployee = Utilities::sanitizeInput($_POST["iscompanyemployee"]);
        $user_id = Utilities::sanitizeInput($_POST["user_id"]);

        $emptyError = "";
        try {

            if ($util->isEmpty($proctorname)) {
                $emptyErrors = "Please fill the empty fields";
            }

            if (empty($emptyError)) {
                $proctorContr->createProctor($proctorname, $iscompanyemployee, $user_id);
                header("location: proctors.php");
            }
        } catch (PDOException $e) {
            echo "Query failed " . $e->getMessage();
        }
        break;

    default:
        break;
}

?>

<?php include_once 'component/header.php'; ?>

<div class="container">

    <h1 class="text-center my-4">Proctor Lists</h1>
    <div>
        <a href="createProctor.php" class="btn btn-success my-2">Add Proctor</a>
    </div>
    <table class="table table-dark rounded">
        <thead>
            <tr>
                <th>No.</th>
                <th>Proctor Name</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($rows) : ?>

                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td> <?php echo $row['proctor_id']; ?></td>
                        <td>
                            <a class="text-decoration-none fw-bold text-light link-danger" href="#">
                                <?php echo ucwords(htmlspecialchars($row['proctor_name'])); ?>
                            </a>
                        </td>


                        <td><?php echo ucwords(htmlspecialchars($row['user_name'])); ?></td>
                        <td>
                            <a href="editProctor.php?id=<?= $row['proctor_id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                            <a href="deleteProctor.php?id=<?= $row['proctor_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Delete</a>
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