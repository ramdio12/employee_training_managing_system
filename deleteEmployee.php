<?php

include 'Employees/EmployeesModel.php';
$empModel = new EmployeesModel;

$id = trim($_GET["id"]);
$empModel->delete($id);
header("Location: employees.php");
