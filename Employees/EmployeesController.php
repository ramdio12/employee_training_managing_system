<?php


/*
THIS CLASS IS MORE ON receving request from the view and sending request to the model

returns either true or false (success or fail) message
 */



require_once 'EmployeesModel.php';
class EmployeesController
{

    private $model;

    public function __construct()
    {
        $objModel = new EmployeesModel;
        $this->model = $objModel;
    }

    public function createEmployee(string $employeename, string $position, $user_id)
    {
        return $this->model->insertEmployee($employeename, $position, $user_id);
    }

    public function getEmployeeById(int $id)
    {
        return $this->model->getEmployeeData($id);
    }

    public function updateEmployeeById(string $id, string $employeename, string $position)
    {
        return $this->model->updateEmployee($id, $employeename, $position);
    }
}
