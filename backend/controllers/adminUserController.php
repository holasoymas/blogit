<?php
require_once '../config/db.php';
require_once '../models/adminUserModel.php';

class AdminUserController
{
  private $adminUser;

  public function __construct()
  {
    $db = new Database();
    $this->adminUser = new AdminUserModel($db);
  }

  public function getUsers()
  {
    $users = $this->adminUser->getUsers();

    if (!$users) {
      http_response_code(404);
      echo json_encode(['error' => 'No users found']);
      exit;
    }

    $jsonResponse = json_encode($users);

    if (json_last_error() !== JSON_ERROR_NONE) {
      http_response_code(500);
      echo json_encode(['error' => 'Failed to encode JSON: ' . json_last_error_msg()]);
      exit;
    }

    http_response_code(200);
    echo $jsonResponse;
  }
}
