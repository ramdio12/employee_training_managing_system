<?php


/*
THIS CLASS IS MORE ON receving request from the view and sending request to the model

returns either true or false (success or fail) message
 */

require_once 'TrainingModel.php';



class TrainingController
{

    private $model;

    public function __construct()
    {
        $objModel = new TrainingModel;
        $this->model = $objModel;
    }


    public function isEmpty(string $trainingname)
    {
        if (empty($trainingname)) {
            return true;
        } else {
            return false;
        }
    }

    public function isNumeric(int $nums)
    {
        if (is_int($nums) || is_integer($nums)) {
            return true;
        } else {
            return false;
        }
    }

    public function createTraining(string $trainingname, string $trainingtype, $user_id)
    {
        return $this->model->insertTraining($trainingname, $trainingtype, $user_id);
    }

    public function getTrainingDataById(int $id)
    {
        return $this->model->getTrainingData($id);
    }

    public function updateTrainingDataById(string $id, string $trainingname, string $trainingtype)
    {
        return $this->model->updateTraining($id, $trainingname, $trainingtype);
    }
}
