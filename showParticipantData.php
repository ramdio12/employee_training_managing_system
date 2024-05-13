<?php

session_start();

// view all trainings in the data table

include 'utilities/Utilities.php';
include_once 'TrainingConduct/TrainingConductModel.php';

if (isset($_GET['name'])) {
    $tcModel = new TrainincConductModel;
    $rows = $tcModel->getParticipantByName($_GET['name']);
} else {
    header('Location: views/error.php?message=url_error');
}

?>



<?php include_once 'component/header.php'; ?>
<div class="container w-75 mx-auto">
    <h1 class="text-center my-5">Participant's Training Data</h1>

    <div>
        <p class="fs-4">Participant Name: <?= ucwords($_GET['name']) ?></p>
    </div>

    <div class="mx-auto">
        <h2 class="text-center my-3">Trainings Attended</h2>
        <ol class="mx-auto">
            <?php if ($rows) : ?>
                <?php foreach ($rows as $row) : ?>
                    <li class="fs-5"><span><?= ucwords($row['training_name']) ?></span> - <span><?= date('F j Y', strtotime($row['training_date']));  ?></span> </li>

                <?php endforeach; ?>
            <?php else : ?>
                <li class="fs-5">No trainings yet</li>
            <?php endif; ?>
        </ol>

    </div>



</div>
<?php include_once 'component/footer.php'; ?>