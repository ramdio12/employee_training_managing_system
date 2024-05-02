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
        $id = Utilities::sanitizeInput($_GET["id"]);
        $row = $proctorModel->getProctorData($id);
        break;
    case 'POST':
        $id = Utilities::sanitizeInput($_POST["proctor_id"]);
        $proctorname = Utilities::sanitizeInput($_POST["proctorname"]);


        $emptyError = "";
        try {

            if ($util->isEmpty($proctorname)) {
                $emptyErrors = "Please fill the empty fields";
            }

            if (empty($emptyError)) {
                $proctorContr->updateProctorDataById($id, $proctorname);
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proctor</title>
    <?php include_once 'component/links.php'; ?>
</head>

<body>
    <?php include_once 'component/nav.php'; ?>


    <div class="container mt-5">
        <h1 class="text-center">Edit Proctor</h1>

        <div class="trainingformdiv">
            <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">
                <div class="mb-3">
                    <label for="proctorname" class="form-label">Proctor Name</label>
                    <input type="text" class="form-control shadow-sm p-3" id="proctorname" name="proctorname" value="<?= $row['proctor_name']; ?>">
                </div>
                <!-- <div class="mb-3">
                    <label for="iscompanyemployee" class="form-label ">Company Employee</label>
                    <select name="iscompanyemployee" id="iscompanyemployee" class="form-select shadow-sm p-3">
                        <option value="y">Yes</option>
                        <option value="n">No</option>

                    </select>
                </div> -->
                <input type="hidden" value="<?= $row['proctor_id']; ?>" name="proctor_id">

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