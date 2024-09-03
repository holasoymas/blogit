<?php
// controllers/userController.php
require_once '../models/userModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';

class UserController
{
  private $userModel;

  public function __construct()
  {
    $db = new Database();
    $this->userModel = new UserModel($db);
  }

  public function createUser($data)
  {
    $fname = $data['fname'];
    $lname = $data['lname'];
    $dob = $data['dob'];
    $email = $data['email'];
    $password = $data['password'];

    // Validation can be added here...

    $userId = $this->userModel->createUser($fname, $lname, $dob, $email, $password);
    echo json_encode(["message" => "User created successfully", "userId" => $userId]);
  }


  public function getUserById($uid)
  {
    // Get the user data from the model
    $userData = $this->userModel->getUserById($uid);
    // echo json_encode(["uid" => $uid]);
    // Check if user data is not null
    if ($userData) {
      // Return user data in JSON format
      echo json_encode($userData);
    } else {
      // Handle the case where no user data is found
      echo json_encode(["error" => "User not found"]);
    }
  }

  public function loginUser($data)
  {
    $email = $data["email"];
    $password = $data["password"];

    $userId = $this->userModel->loginUser($email, $password);
    if ($userId) {
      SessionManager::startSession();
      SessionManager::setSession("uid", $userId);
      echo json_encode(["data" => $userId]);
    } else {
      echo json_encode(["error" => "No user found"]);
    }
  }
  // Other user-related operations...
}
