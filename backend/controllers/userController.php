<?php
// controllers/userController.php
require_once '../models/userModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';
require_once '../services/generateProfile.php';

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
    $errors = [];

    $fname = $data['fname'];
    $lname = $data['lname'];
    $dob = $data['dob'];
    $email = $data['email'];
    $password = $data['password'];

    // Validation can be added here...
    if (empty($data['fname'])) {
      $errors['fname'] = "Firstname is required";
    }

    // Validate Lastname
    if (empty($data['lname'])) {
      $errors['lname'] = "Lastname is required";
    }

    // Validate Date of Birth
    if (empty($data['dob'])) {
      $errors['dob'] = "Date of birth is required";
    }

    // Validate Email
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "A valid email is required";
    }

    // Validate Password
    if (empty($data['password'])) {
      $errors['password'] = "Password is required";
    } elseif (strlen($data['password']) < 6) {
      $errors['password'] = "Password must be at least 6 characters long";
    }

    // If there are validation errors, return them as a JSON response
    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode([
        "status" => "error",
        "errors" => $errors
      ]);
      return;
    }

    $profile_pic = generateRandomColor();
    $userId = $this->userModel->createUser($fname, $lname, $dob, $email, $password, $profile_pic);
    SessionManager::setSession("uid", $userId);
    http_response_code(201);
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
      http_response_code(200);
      echo json_encode($userData);
    } else {
      // Handle the case where no user data is found
      http_response_code(404);
      echo json_encode(["error" => "User not found"]);
    }
  }

  public function loginUser($data)
  {
    $email = $data["email"];
    $password = $data["password"];

    $userId = $this->userModel->loginUser($email, $password);
    if ($userId) {
      SessionManager::setSession("uid", $userId);
      http_response_code(200);
      echo json_encode(["userId" => $userId]);
    } else {
      http_response_code(400);
      echo json_encode(["errors" => "Invalid Crediantials"]);
    }
  }
  // Other user-related operations...
}
