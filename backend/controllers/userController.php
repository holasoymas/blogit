<?php
// controllers/userController.php
require_once '../models/userModel.php';
require_once '../config/db.php';

class UserController {
    private $userModel;

    public function __construct() {
        $db = new Database();
        $this->userModel = new UserModel($db);
    }

    public function createUser($data) {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];

        // Validation can be added here...

        $userId = $this->userModel->createUser($name, $email, $password);
        echo json_encode(["message" => "User created successfully", "userId" => $userId]);
    }

    // Other user-related operations...
}

