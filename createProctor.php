<?php

session_start();

include_once 'utilities/Utilities.php';
include_once 'Proctor/ProctorModel.php';
include_once 'Proctor/ProctorController.php';


$proctorModel = new ProctorModel;
$proctorContr = new ProctorController;
$util = new Utilities;


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $proctorname = Utilities::sanitizeInput($_POST["proctorname"]);
    $user_id = Utilities::sanitizeInput($_POST["user_id"]);

    $emptyError = "";
    try {

        if ($util->isEmpty($proctorname)) {
            $emptyErrors = "Please fill the empty fields";
        }

        if (empty($emptyError)) {
            $proctorContr->createProctor($proctorname, $user_id);
            header("location: proctors.php");
        }
    } catch (PDOException $e) {
        echo "Query failed " . $e->getMessage();
    }
}

?>


<?php include_once 'component/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Add Proctor</h1>

    <div class="trainingformdiv">
        <form class="w-50 mx-auto" action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">
            <div class="mb-3">
                <label for="proctorname" class="form-label">Proctor Name</label>
                <input type="text" class="form-control shadow-sm p-3" id="proctorname" name="proctorname">
            </div>
            <!-- <div class="mb-3">
                    <label for="iscompanyemployee" class="form-label ">Company Employee</label>
                    <select name="iscompanyemployee" id="iscompanyemployee" class="form-select shadow-sm p-3">
                        <option value="y">Yes</option>
                        <option value="n">No</option>

                    </select>
                </div> -->
            <input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="user_id">

            <div>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>

            <?php if (isset($emptyErrors)) : ?>
                <p><?= $emptyErrors; ?></p>
            <?php endif ?>
        </form>
    </div>
</div>


<?php include_once 'component/footer.php'; ?>