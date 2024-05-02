<?php

/*
THIS CLASS IS MORE ON receving request from the view and sending request to the model

returns either true or false (success or fail) message
 */


require_once 'ProctorModel.php';



class ProctorController
{

    private $model;

    public function __construct()
    {
        $objModel = new ProctorModel;
        $this->model = $objModel;
    }

    public function createProctor(string $proctorname, $user_id)
    {
        return $this->model->insertProctor($proctorname, $user_id);
    }

    public function getProctorById(int $id)
    {
        return $this->model->getProctorData($id);
    }

    public function updateProctorDataById(string $id, string $proctorname)
    {
        return $this->model->updateProctor($id, $proctorname);
    }
}
