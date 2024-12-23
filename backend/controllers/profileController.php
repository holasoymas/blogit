<?php
require_once '../models/profileModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';

class ProfileController
{
  private $profileModel;

  public function __construct()
  {
    $db = new Database();
    $this->profileModel = new ProfileModel($db);
  }

  public function getUserProfileById($uid)
  {
    $userData = $this->profileModel->getUserProfileById($uid);
    if ($userData["user"]) {
      $response = [
        "user" => $userData["user"],
        "blogs" => $userData["blogs"],
        "loggedInUser" => SessionManager::getAuthenticatedUser()
      ];
      http_response_code(200);
      echo json_encode($response);
    } else {
      // Handle the case where no user data is found
      http_response_code(404);
      echo json_encode(["error" => "User not found"]);
    }
  }
}
