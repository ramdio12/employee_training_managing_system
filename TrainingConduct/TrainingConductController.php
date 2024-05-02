<?php

/*
THIS CLASS IS MORE ON receving request frm the view and sending request to the model

returns either true or false (success or fail)
 */

require_once 'TrainingConductModel.php';
class TrainingConductController
{

    private $model;

    public function __construct()
    {
        $objModel = new TrainincConductModel;
        $this->model = $objModel;
    }

    public function createTrainingConduct(string $trainingname, string $proctorname, string $trainingdate, $user_id)
    {
        return $this->model->insertTrainingConduct($trainingname, $proctorname, $trainingdate, $user_id);
    }

    public function getTrainingDataById(int $id)
    {
        return $this->model->showTrainingDataById($id);
    }
    public function getEmployeesByTCId(int $id)
    {
        return $this->model->showAllEmployeesById($id);
    }

    // public function updateEmployeeById(string $id, string $employeename, string $department, string $position)
    // {
    //     return $this->model->updateEmployee($id, $employeename, $department, $position);
    // }
}
