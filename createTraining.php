<?php

session_start();

include_once 'utilities/Utilities.php';
include_once 'Training/TrainingController.php';



$trainingContr = new TrainingController;
$util = new Utilities;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $trainingname = Utilities::sanitizeInput($_POST["trainingname"]);
    $trainingtype = Utilities::sanitizeInput($_POST["trainingtype"]);
    $user_id = Utilities::sanitizeInput($_POST["user_id"]);

    $emptyError = "";
    try {

        if ($util->isEmpty($trainingname)) {
            header('createTraining.php');
            $emptyErrors = "Please fill the empty fields";
        } else {
            if (empty($emptyError)) {
                $trainingContr->createTraining($trainingname, $trainingtype, $user_id);
                header("location: trainings.php");
            }
        }
    } catch (PDOException $e) {
        echo "Query failed " . $e->getMessage();
    }
}


?>

<?php include_once 'component/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Add Training</h1>

    <div class="">
        <form class="w-50 mx-auto" action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">
            <div class="mb-3">
                <label for="trainingname" class="form-label">Training Name</label>
                <input type="text" class="form-control shadow-sm p-3" id="trainingname" name="trainingname">
            </div>

            <div class="mb-3">
                <label for="trainingtype" class="form-label ">Training Type</label>
                <select name="trainingtype" id="trainingtype" class="form-select shadow-sm p-3">
                    <option value="web development">Web Development</option>
                    <option value="programming">Programming</option>
                    <option value="web design">UI/UX Design</option>
                    <option value="dev ops">Dev Ops</option>
                </select>
            </div>


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