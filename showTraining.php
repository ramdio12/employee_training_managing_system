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

switch ($method) {
    case 'GET':

        try {

            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                $id = Utilities::sanitizeInput($_GET["id"]);
                $participants = $tcModel->getAllParticipantsById($id);
                $employees = $empModel->getAllEmployeesNames();
                $row = $tcModel->showTrainingDataByDate($id);
            } else {
                header('Location: views/error.php?message=url_error');
            }
        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }

        break;

    case 'POST':
        $participantname = Utilities::sanitizeInput($_POST["participantname"]);
        $tc_id = Utilities::sanitizeInput($_POST["tc_id"]);
        $user_id = Utilities::sanitizeInput($_POST["user_id"]);

        try {

            if ($tcModel->getParticipant($participantname, $tc_id)) {
                header("Location: showTraining.php?id={$tc_id}");
            } else {
                $tcModel->insertParticipant($participantname, $tc_id, $user_id);
                header("Location: showTraining.php?id={$tc_id}");
            }
        } catch (PDOException $e) {
            echo "Insert Failed " . $e->getMessage();
        }
        break;

    default:
        # code...
        break;
}






?>



<?php include_once 'component/header.php'; ?>

<h1 class="text-center fs-1 fw-bold my-4"><?php echo htmlspecialchars(ucwords($row["training_name"])); ?></h1>

<div class="container">
    <div>
        <p class="fs-5 fw-semibold">Training Date: <span class="fw-normal">
                <?= date('F j Y', strtotime($row['training_date']));  ?>
            </span></p>
        <p class="fs-5 fw-semibold">Proctor Name: <span class="fw-normal"><?php echo htmlspecialchars(ucwords($row["proctor_name"])); ?></span></p>
    </div>




    <div class="d-flex align-items-center justify-content-center flex-column">

        <?php if ($participants) : ?>

            <table class="table table-dark w-25 rounded overflow-hidden table-responsive">
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



    <div class="my-5">
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
            <input type="hidden" name="tc_id" value="<?= $_GET["id"]; ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">

            <button class="btn btn-primary" type="submit">Add Participant</button>
        </form>

        <?php if (isset($err)) : ?>
            <?= $err; ?>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'component/footer.php'; ?>