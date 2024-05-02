<?php


/*
      MODEL IS USED FOR COMMUNICATING WITH DATABASE
    */



require_once 'Database/DatabaseConnect.php';

class ProctorModel
{

    private $conn;

    public function __construct()
    {
        $objDb = new DatabaseConnect;
        $this->conn = $objDb->connect();
    }

    public function insertProctor(string $proctorname,  $user_id)
    {
        $sql = "INSERT INTO proctors (proctor_name,user_id) VALUES (:name, :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $proctorname);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    public function getAllProctors()
    {
        $sql = "SELECT proctors.proctor_id, proctors.proctor_name,proctors.created_at,users.user_name FROM users RIGHT JOIN proctors ON users.user_id = proctors.user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getProctorData(int $id)
    {
        $sql = "SELECT * FROM proctors WHERE proctor_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function updateProctor(string $id, string $proctorname)
    {
        $sql = "UPDATE proctors SET proctor_name = :name WHERE proctor_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $proctorname);
        $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM proctors WHERE proctor_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // get all proctor name to inserted to training_proctor table
    public function getAllProctorName()
    {
        $sql = "SELECT proctor_name FROM proctors";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
