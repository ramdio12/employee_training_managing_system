<?php

session_start();

include_once 'Training/TrainingModel.php';

$trainingModel = new TrainingModel;
$rows = $trainingModel->getAllTraining();


?>



<?php include_once 'component/header.php'; ?>

<div class="container">

    <h1 class="text-center my-4">Training Lists</h1>
    <div>
        <a href="createTraining.php" class="btn btn-success my-2">Add Training</a>
    </div>
    <table class="table table-dark rounded">
        <thead>
            <tr>
                <th>No.</th>
                <th>Proctor Name</th>
                <th>Training Type</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($rows) : ?>

                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td> <?php echo $row['training_id']; ?></td>
                        <td>
                            <a class="text-decoration-none fw-bold text-light link-danger" href="#">
                                <?php echo ucwords(htmlspecialchars($row['training_name'])); ?>
                            </a>
                        </td>
                        <td> <?php echo ucwords(htmlspecialchars($row['training_type'])); ?></td>


                        <td><?php echo ucwords(htmlspecialchars($row['user_name'])); ?></td>
                        <td>
                            <a href="editTraining.php?id=<?= $row['training_id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                            <a href="deleteTraining.php?id=<?= $row['training_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Delete</a>
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