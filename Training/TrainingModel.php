<?php
/*
      MODEL IS USED FOR COMMUNICATING WITH DATABASE
    */
require_once 'Database/DatabaseConnect.php';

class TrainingModel
{

    private $conn;

    public function __construct()
    {
        $objDb = new DatabaseConnect;
        $this->conn = $objDb->connect();
    }

    public function insertTraining(string $trainingname, string $trainingtype, $user_id)
    {
        $sql = "INSERT INTO trainings (training_name,training_type,user_id) VALUES (:trainingname, :trainingtype, :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':trainingname', $trainingname);
        $stmt->bindParam(':trainingtype', $trainingtype);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    // get all training name
    public function getAllTraining()
    {
        $sql = "SELECT trainings.training_id, trainings.training_name,trainings.training_type,trainings.created_at,users.user_name FROM users RIGHT JOIN trainings ON users.user_id = trainings.user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateTraining(string $id, string $trainingname, string $trainingtype)
    {
        $sql = "UPDATE trainings SET training_name = :trainingname, training_type = :trainingtype WHERE training_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':trainingname', $trainingname);
        $stmt->bindParam(':trainingtype', $trainingtype);
        $stmt->execute();
    }


    // delete training
    public function delete($id)
    {
        $sql = "DELETE FROM trainings WHERE training_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // get training name to be inserted in training_proctor table along with proctor's name
    // get training name to be inserted in participant table along with employee's name as the participant
    public function getAllTrainingName()
    {
        $sql = "SELECT training_name from trainings";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    // show training data by ID - practice
    public function getTrainingData(int $id)
    {
        $sql = "SELECT * FROM trainings WHERE training_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}


 //     $sql = "UPDATE users SET name = :name, username = :username, email = :email WHERE id = :id";
        //     $stmt = $conn->prepare($sql);
        //     $stmt->bindParam(':id', $id);
        //     $stmt->bindParam(':name', $name);
        //     $stmt->bindParam(':username', $username);
        //     $stmt->bindParam(':email', $email);
        //     $stmt->execute();