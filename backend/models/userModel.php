<?php
// models/userModel.php
class UserModel {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db->connect();
    }

    public function createUser($name, $email, $password) {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
        return $this->pdo->lastInsertId();
    }

    // Other user-related database operations...
}

