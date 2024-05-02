<?php
session_start();


include 'utilities/Utilities.php';
include_once 'Training/TrainingModel.php';
include_once 'Proctor/ProctorModel.php';
include_once 'TrainingConduct/TrainingConductController.php';

$trainingModel = new TrainingModel;
$proctorModel = new ProctorModel;
$tcContr = new TrainingConductController;
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $trainingnames = $trainingModel->getAllTrainingName();
        $proctornames = $proctorModel->getAllProctorName();
        break;
    case 'POST':
        $trainingname = Utilities::sanitizeInput($_POST["trainingname"]);
        $proctorname = Utilities::sanitizeInput($_POST["proctorname"]);
        $trainingdate = Utilities::sanitizeInput($_POST["trainingdate"]);
        $userid = Utilities::sanitizeInput($_POST["user_id"]);


        try {
            $tcContr->createTrainingConduct($trainingname, $proctorname, $trainingdate, $userid);
        } catch (PDOException $e) {
            echo "Insert error: " . $e->getMessage();
        }
        break;

    default:
        # code...
        break;
}


?>


<?php include_once 'component/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Encode Training</h1>

    <div class="">
        <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST" class="mx-auto w-50">

            <?php if ($trainingnames) : ?>
                <div class="mb-3">
                    <label for="trainingname" class="form-label">Training Name</label>
                    <select name="trainingname" id="trainingname" class="form-select shadow-sm p-3 w-75">

                        <?php foreach ($trainingnames as $trainingname) : ?>
                            <option value="<?= $trainingname['training_name']; ?>">
                                <?= $trainingname['training_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ($proctornames) : ?>
                <div class="mb-3">
                    <label for="proctorname" class="form-label">Proctor Name</label>
                    <select name="proctorname" id="proctorname" class="form-select shadow-sm p-3 w-75">

                        <?php foreach ($proctornames as $proctorname) : ?>
                            <option value="<?= $proctorname['proctor_name']; ?>">
                                <?= $proctorname['proctor_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="trainingdate" class="form-label ">Training Date</label>
                <input class="w-25 form-control" type="date" name="trainingdate" id="trainingdate">
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