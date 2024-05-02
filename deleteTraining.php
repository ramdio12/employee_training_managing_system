<?php
include 'Training/TrainingModel.php';
$trainingModel = new TrainingModel;

$id = trim($_GET["id"]);

$trainingModel->delete($id);
header('location: trainings.php');
