<?php
/*
      MODEL IS USED FOR COMMUNICATING WITH DATABASE
    */
require_once 'Database/DatabaseConnect.php';


class TrainincConductModel
{
    private $conn;

    public function __construct()
    {
        $objDb = new DatabaseConnect;
        $this->conn = $objDb->connect();
    }

    // INSERT TRAINING NAME WITH PROCTOR AND THE TRAINING DATE
    public function insertTrainingConduct(string $trainingname, string $proctorname, string $trainingdate, $user_id,)
    {
        $sql = "INSERT INTO training_proctor (training_id, proctor_id,training_date,user_id)
        VALUES (
            (SELECT training_id FROM trainings WHERE training_name = :trainingname),
            (SELECT proctor_id FROM proctors WHERE proctor_name = :proctorname),
            :trainingdate,
            (SELECT user_id FROM users WHERE user_id = :user_id)
        )";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':trainingname', $trainingname);
        $stmt->bindParam(':proctorname', $proctorname);
        $stmt->bindParam(':trainingdate', $trainingdate);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    // INSERT PARTCIPANT IN A TRAINING WITH TRAINING DATE
    public function insertParticipant(string $employeename, string $trainingname, $trainingdate)
    {
        $sql = "INSERT INTO participant (employee_id,training_id,training_date)
        VALUES (
            (SELECT employee_id FROM employees WHERE employee_name = :employeename),
            (SELECT training_id FROM trainings WHERE training_name = :trainingname),
            :training_date
        )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':employeename', $employeename);
        $stmt->bindParam(':trainingname', $trainingname);
        $stmt->bindParam(':training_date', $trainingdate);
        $stmt->execute();
    }

    // GET ALL PARTICIPANTS BY TRAINING NAME AND TRAINING DATE
    public function getParticipantsByTraining(string $trainingname, $trainingdate)
    {
        $sql = "SELECT e.employee_name AS participant_name FROM participant pa JOIN trainings t ON pa.training_id = t.training_id JOIN training_proctor tp ON t.training_id = tp.training_id JOIN employees e ON pa.employee_id = e.employee_id WHERE t.training_name = :trainingname AND tp.training_date = :trainingdate AND pa.training_date = :trainingdate;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':trainingname', $trainingname);
        $stmt->bindParam(':trainingdate', $trainingdate);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // get all trainings that were conducted in the company
    public function getAllTrainingConduct()
    {
        $sql = "SELECT 
        t.training_name,
        tp.training_date,
        p.proctor_name,
       u.user_name
    FROM 
        trainings t
    JOIN 
        training_proctor tp ON t.training_id = tp.training_id
    JOIN 
       proctors p ON tp.proctor_id = p.proctor_id
    JOIN 
        users u ON tp.user_id = u.user_id
        ORDER BY tp.training_date;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    // SHOW INFORMATION OF TRAINING CONDUCTED IN A SPECIFIC DATE
    public function showTrainingDataByDate($trainingname, $trainingdate)
    {
        $sql = "SELECT
            t.training_name,
            tp.training_date,
            p.proctor_name,
            u.user_name
        FROM 
            trainings t
        JOIN 
            training_proctor tp ON t.training_id = tp.training_id
        JOIN 
           proctors p ON tp.proctor_id = p.proctor_id
        JOIN 
            users u ON tp.user_id = u.user_id 
        WHERE 
        t.training_name = :trainingname
    AND tp.training_date = :trainingdate";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':trainingdate', $trainingdate);
        $stmt->bindParam(':trainingname', $trainingname);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }



    public function getParticipantByName(string $name)
    {
        $sql = "SELECT
        t.training_name,
        p.training_date
    FROM 
        trainings t
    JOIN 
        participant p ON t.training_id = p.training_id
    JOIN 
        employees e ON p.employee_id = e.employee_id
    WHERE 
        e.employee_name = :employeename";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':employeename', $name);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // to avoid duplication, we will check the participant's name on the participant's table
    // if it is already joined on a training on a specific date, then there will be no action 
    public function getParticipant(string $employeename, string $trainingname, string $trainingdate)
    {
        $sql = "SELECT
        e.employee_name
    FROM 
        employees e
    JOIN 
        participant p ON e.employee_id = p.employee_id
    JOIN 
        trainings t ON p.training_id = t.training_id
    WHERE 
        e.employee_name = :employeename
        AND t.training_name = :trainingname AND p.training_date = :trainingdate";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':employeename', $employeename);
        $stmt->bindParam(':trainingname', $trainingname);
        $stmt->bindParam(':trainingdate', $trainingdate);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }



    // JUST A SAMPLE QUERY , FOR PRACTICE PURPOSES
    public function showTrainingDataById(int $id)
    {
        $sql = "SELECT
        tc.id,
        u.username,
        t.trainingname,
        t.trainingtype,
        p.name,
        tc.created_at
    FROM
        trainingConduct tc
    JOIN
        users u ON tc.user_id = u.id
    JOIN
        trainings t ON tc.training_id = t.id
    JOIN
        proctors p ON tc.proctor_id = p.id
    WHERE tc.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }




    // JUST A SAMPLE QUERY , FOR PRACTICE PURPOSES
    public function showAllEmployeesById(int $id)
    {
        $sql = "SELECT
        e.name,
        e.department,
        e.position,
        tc.employee_id
    FROM
        trainingConduct tc
    JOIN
        employees e ON tc.employee_id = e.id
    WHERE tc.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }





    // FOR TRAINING PURPOSES
    public function delete($id)
    {
        $sql = "DELETE FROM employees WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


    // public function updateEmployee(string $id, string $employeename, string $department, string $position)
    // {
    //     $sql = "UPDATE employees SET name = :name, department = :department, position = :position WHERE id = :id";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bindParam(':id', $id);
    //     $stmt->bindParam(':name', $employeename);
    //     $stmt->bindParam(':department', $department);
    //     $stmt->bindParam(':position', $position);
    //     $stmt->execute();
    // }
}
