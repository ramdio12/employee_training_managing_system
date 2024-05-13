<?php
session_start();

// view all trainings in the data table

include 'utilities/Utilities.php';
include_once 'TrainingConduct/TrainingConductModel.php';
include_once 'TrainingConduct/TrainingConductController.php';
include_once 'Employees/EmployeesModel.php';

$tcModel = new TrainincConductModel;
$tcContr = new TrainingConductController;
$empModel = new EmployeesModel;


$method = $_SERVER['REQUEST_METHOD'];
try {
    switch ($method) {
        case 'GET':
            $tname = Utilities::sanitizeInput($_GET["tname"]);
            $date = Utilities::sanitizeInput($_GET["date"]);
            $row = $tcModel->showTrainingDataByDate($tname, $date);
            $participants = $tcModel->getParticipantsByTraining($_GET["tname"], $_GET["date"]);
            $employees = $empModel->getAllEmployeesNames();
            break;

        case 'POST':
            $participantname = Utilities::sanitizeInput($_POST["participantname"]);
            $trainingname = Utilities::sanitizeInput($_POST["trainingname"]);
            $trainingdate = Utilities::sanitizeInput($_POST["trainingdate"]);

            try {
                if ($tcModel->getParticipant($participantname, $trainingname, $trainingdate)) {
                    header("Location: showTraining.php?date={$trainingdate}&tname={$trainingname}");
                } else {
                    $tcModel->insertParticipant($participantname, $trainingname, $trainingdate);
                    header("Location: showTraining.php?date={$trainingdate}&tname={$trainingname}");
                }
            } catch (PDOException $e) {
                echo "Insert Failed " . $e->getMessage();
            }
            break;

        default:
            # code...
            break;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}






?>



<?php include_once 'component/header.php'; ?>

<h1 class="text-center fs-1 fw-bold my-4"><?php echo htmlspecialchars(ucwords($row["training_name"])); ?></h1>

<div class="container">
    <div>
        <p class="fs-5 fw-semibold">Training Date: <span class="fw-normal"><?php echo $row["training_date"] ?></span></p>
        <p class="fs-5 fw-semibold">Proctor Name: <span class="fw-normal"><?php echo htmlspecialchars(ucwords($row["proctor_name"])); ?></span></p>
    </div>




    <div class="d-flex align-items-center justify-content-center flex-column">

        <?php if ($participants) : ?>

            <table class="table table-dark w-25 rounded overflow-hidden">
                <thead>
                    <tr>
                        <th class="text-center fs-3">Participants</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($participants as $participant) : ?>
                        <tr>
                            <td><?= ucwords($participant['participant_name']); ?></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        <?php endif; ?>
    </div>



    <div class="">
        <h3>Add Participant</h3>
        <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">
            <div class="mb-3">
                <label for="participantname">Participant Name</label>
                <select name="participantname" id="participantname" class="form-select w-25">
                    <?php if ($employees) : ?>
                        <?php foreach ($employees as $employee) : ?>
                            <option value="<?= $employee['employee_name'] ?>"><?= $employee['employee_name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php ?>
                </select>
            </div>
            <input type="hidden" name="trainingdate" value="<?= $_GET["date"]; ?>">
            <input type="hidden" name="trainingname" value="<?= $_GET["tname"]; ?>">
            <button class="btn btn-primary" type="submit">Add Participant</button>
        </form>

        <?php if (isset($err)) : ?>
            <?= $err; ?>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'component/footer.php'; ?>