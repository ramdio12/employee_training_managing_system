<?php


/*
      MODEL IS USED FOR COMMUNICATING WITH DATABASE
    */


require_once 'Database/DatabaseConnect.php';


class EmployeesModel
{
    private $conn;

    public function __construct()
    {
        $objDb = new DatabaseConnect;
        $this->conn = $objDb->connect();
    }

    public function insertEmployee(string $employeename, string $position, $user_id)
    {
        $sql = "INSERT INTO employees (employee_name,position,user_id) VALUES (:name,:position, :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $employeename);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    public function getAllEmployees()
    {
        $sql = "SELECT employees.employee_id, employees.employee_name,employees.position,employees.created_at,users.user_name FROM users RIGHT JOIN employees ON users.user_id = employees.user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getEmployeeData(int $id)
    {
        $sql = "SELECT * FROM employees WHERE employee_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function updateEmployee(string $id, string $employeename, string $position)
    {
        $sql = "UPDATE employees SET employee_name = :name, position = :position WHERE employee_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $employeename);
        $stmt->bindParam(':position', $position);
        $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM employees WHERE employee_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // get all employees names to be inserted to participants table along with training name and date
    public function getAllEmployeesNames()
    {
        $sql = "SELECT employee_name FROM employees ORDER BY employee_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
