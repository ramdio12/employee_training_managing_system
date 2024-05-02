<?php
session_start();

if (isset($_SESSION["user_username"])) {
    $users_username = $_SESSION["user_username"];
}

include_once 'TrainingConduct/TrainingConductModel.php';
$tcModel = new TrainincConductModel;
$rows = $tcModel->getAllTrainingConduct();

?>


<?php include_once 'component/header.php'; ?>


<h1 class="text-center mt-3 mb-5">Welcome to Dashboard <?= $users_username; ?> </h1>


<div class="container">
    <div>
        <a href="createTrainingConduct.php" class="btn btn-success my-2">Encode Training</a>
    </div>
    <?php if ($rows) : ?>
        <table class="table table-dark rounded">
            <thead>

                <tr>
                    <th>Training</th>
                    <th>Training Date</th>
                    <th>Proctor</th>
                    <th>Encoded By</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : ?>

                    <tr>

                        <td>
                            <a class="text-decoration-none fs-6 text-white fw-bold linkhover" href="showTraining.php?date=<?= $row['training_date']; ?>&tname=<?= $row['training_name']; ?>">
                                <?= ucwords(htmlspecialchars($row['training_name'])); ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($row['training_date']) ?></td>
                        <td><?= ucwords(htmlspecialchars($row['proctor_name'])) ?></td>
                        <td><?= ucwords(htmlspecialchars($row['user_name'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>


        </table>

    <?php else : ?>
    <?php endif; ?>

    <?php ?>


</div>


<?php include_once 'component/footer.php'; ?>