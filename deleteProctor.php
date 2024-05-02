<?php
include 'Proctor/ProctorModel.php';
$proctorModel = new ProctorModel;

$id = trim($_GET["id"]);

$proctorModel->delete($id);
header('location: proctors.php');
