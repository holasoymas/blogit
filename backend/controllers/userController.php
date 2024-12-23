<?php
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

  public function returnValidateErr($fname, $lname, $dob, $email, $password)
  {
    $errors = [];
    if (empty($fname) || !preg_match('/^[A-Z][a-zA-Z]{3,}$/', $fname)) {
      $errors['fname'] = "First name must start with a capital letter and should contain at least 4 letters";
    }
    if (empty($lname) || !preg_match('/^[A-Z][a-zA-Z]{3,}$/', $lname)) {
      $errors['lname'] = "Last name must start with a capital letter and should contain at least 4 letters";
    }
    if (empty($dob)) {
      $errors['dob'] = "Date of birth is required";
    } else {
      try {
        $dobDate = new DateTime($dob);
        $today = new DateTime('now');
        if ($dobDate > $today) {
          $errors['dob'] = "Date of birth cannot be in the future";
        } elseif ($today->diff($dobDate)->y < 16) {
          $errors['dob'] = "You must be at least 16 years old";
        }
      } catch (Exception $e) {
        $errors['dob'] = "Invalid date format. Please use YYYY-MM-DD format";
      }
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "A valid email is required";
    }
    if (empty($password)) {
      $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
      $errors['password'] = "Password must be at least 6 characters long";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/', $password)) {
      $errors['password'] = "Password must contain at least one uppercase letter, one number, and one special character (!@#$%^&*)";
    }
    return $errors;
  }

  public function createUser($data)
  {
    $fname = $data['fname'];
    $lname = $data['lname'];
    $dob = $data['dob'];
    $email = $data['email'];
    $password = $data['password'];

    $errors = $this->returnValidateErr($fname, $lname, $dob, $email, $password);

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


  public function updateUser($data)
  {

    $uid = SessionManager::getSession("uid");
    if (!$uid) {
      http_response_code(401);
      echo json_encode(["error" => "Pleasse login to update"]);
      return;
    }

    $fname = $data['fname'];
    $lname = $data['lname'];
    $dob = $data['dob'];
    $email = $data['email'];
    $password = $data['password'];

    $errors = $this->returnValidateErr($fname, $lname, $dob, $email, $password);

    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode([
        "status" => "error",
        "errors" => $errors
      ]);
      return;
    }

    $userId = $this->userModel->updateUser($uid, $fname, $lname, $dob, $email, $password);
    // SessionManager::setSession("uid", $userId);
    http_response_code(201);
    echo json_encode(["message" => "User updated successfully", "userId" => $userId]);
  }


  public function getUserById($uid)
  {
    $userData = $this->userModel->getUserById($uid);
    if ($userData) {
      http_response_code(200);
      echo json_encode($userData);
    } else {
      http_response_code(404);
      echo json_encode(["error" => "User not found"]);
    }
  }

  public function loginUser($data)
  {
    $errors = [];
    $email = $data["email"];
    $password = $data["password"];

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "A valid email is required";
    }

    if (empty($data['password'])) {
      $errors['password'] = "Password is required";
    } elseif (strlen($data['password']) < 6) {
      $errors['password'] = "Password must be at least 6 characters long";
    }

    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode([
        "status" => "error",
        "errors" => $errors
      ]);
      return;
    }

    $userId = $this->userModel->loginUser($email, $password);
    if ($userId) {
      SessionManager::setSession("uid", $userId);
      http_response_code(200);
      echo json_encode(["userId" => $userId]);
    } else {
      http_response_code(401);
      echo json_encode(["error" => "Invalid Crediantials"]);
    }
  }

  public function deleteUser($uid)
  {
    $userData = $this->userModel->deleteUser($uid);
    if (isset($userData['message'])) {
      http_response_code(200);
      echo json_encode($userData);
    } else {
      http_response_code(404);
      echo json_encode(["error" => "User not found"]);
    }
  }
}
