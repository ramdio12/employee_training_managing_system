<?php
/*
        User Model is responsible for database connection and query
    */
include_once 'Database/DatabaseConnect.php';

class UserModel
{

    private $conn;

    public function __construct()
    {
        $objDb = new DatabaseConnect;
        $this->conn = $objDb->connect();
    }

    /*
        Register Section
    */

    // check if username already exists
    public function checkUsername($username)
    {
        $sql = "SELECT * FROM users WHERE user_name =:username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        return $user;
    }

    // method to register a user
    public function register($username, $role, $password)
    {
        $sql = "INSERT INTO users (user_name,user_role,password) VALUES (:username,:role,:password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }




    /* Login Section */
    // log in a user
    public function login(string $username, string $password)
    {
        $sql = "SELECT * FROM users WHERE user_name = :username AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();


        $count = $stmt->rowCount();
        if ($count > 0) {
            return $stmt->fetch();
        } else {
            return false;
        }
        // $stmt->execute(['email' => $email]);
        // $user = $stmt->fetch();

        // if ($user) {
        //     if (password_verify($password, $user['password'])) {
        //         return $user;
        //     } else {
        //         return false;
        //     }
        // } else {
        //     return false;
        // }
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUser(string $username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function updateUser(int $id, string $username, string $role, string $password)
    {
        $sql = "UPDATE users SET user_name = :username,user_role = :role,password = :password WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }
    public function getUserDataById(int $id)
    {
        $sql = "SELECT * from users WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}


 //     $sql = "UPDATE users SET name = :name, username = :username, email = :email WHERE id = :id";
        //     $stmt = $conn->prepare($sql);
        //     $stmt->bindParam(':id', $id);
        //     $stmt->bindParam(':name', $name);
        //     $stmt->bindParam(':username', $username);
        //     $stmt->bindParam(':email', $email);
        //     $stmt->execute();