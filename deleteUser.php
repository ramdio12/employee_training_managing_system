<?php
include 'User/UserModel.php';
$userModel = new UserModel;

$id = trim($_GET["id"]);
$userModel->delete($id);

header('location: users.php');
