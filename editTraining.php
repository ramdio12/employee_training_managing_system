<?php
session_start();

include 'utilities/Utilities.php';
include 'Training/TrainingController.php';

$trainingContr = new TrainingController;
$utilContr = new Utilities;
$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {

    case 'GET':
        $id = Utilities::sanitizeInput($_GET['id']);
        if (isset($id)) {
            $result = $trainingContr->getTrainingDataById($id);
        }
        break;

    case 'POST':


        $trainingid = Utilities::sanitizeInput($_POST["training_id"]);
        $trainingname = Utilities::sanitizeInput($_POST["trainingname"]);
        $trainingtype = Utilities::sanitizeInput($_POST["trainingtype"]);

        $emptyErrors = $numError = "";

        try {
            if ($utilContr->isEmpty($trainingname)) {
                $emptyErrors = "Please fill the empty fields";
            }

            if (empty($emptyErrors) && empty($numError)) {
                $trainingContr->updateTrainingDataById($trainingid, $trainingname, $trainingtype);
                header("location: trainings.php?message=editsuccess");
            }
        } catch (PDOException $e) {
            echo "Query failed " . $e->getMessage();
        }
        break;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Training</title>
    <?php include_once 'component/links.php'; ?>
</head>

<body>
    <?php include_once 'component/nav.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Edit <?= $result['training_name'] ?></h1>

        <div class="trainingformdiv">
            <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="POST">
                <div class="mb-3">
                    <label for="trainingname" class="form-label">Training Name</label>
                    <input type="text" class="form-control shadow-sm p-3" id="trainingname" name="trainingname" value="<?= $result['training_name'] ?>">
                </div>

                <div class="mb-3">
                    <label for="trainingtype" class="form-label ">Training Type</label>
                    <select name="trainingtype" id="trainingtype" class="form-select shadow-sm p-3">
                        <option value="web development" <?php echo ($result['training_type'] === 'web development') ? 'selected="selected"' : ''; ?>>
                            Web Development
                        </option>
                        <option value="programming" <?php echo ($result['training_type'] === 'programming') ? 'selected="selected"' : ''; ?>>
                            Programming
                        </option>
                        <option value="web design" <?php echo ($result['training_type'] === 'web design') ? 'selected="selected"' : ''; ?>>
                            UI/UX Design
                        </option>
                        <option value="dev ops" <?php echo ($result['training_type'] === 'dev ops') ? 'selected="selected"' : ''; ?>>
                            Dev Ops
                        </option>
                    </select>
                </div>


                <input type="hidden" value="<?= $result['training_id'] ?>" name="training_id">

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