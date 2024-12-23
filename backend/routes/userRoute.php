<?php
header('Content-Type: application/json');
require_once '../controllers/userController.php';

$userController = new UserController();

$uid = isset($_GET['uid']) ? $_GET['uid'] : null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $userController->createUser($data);
}

if ($requestMethod == 'PUT') {
  $data = json_decode(file_get_contents("php://input"), true);
  $userController->updateUser($data);
}

if ($requestMethod == 'GET') {
  if ($uid) {
    $userController->getUserById($uid);
  } else {
    http_response_code(404);
    echo json_encode(["error" => "User ID (uid) is missing"]);
  }
}

if ($requestMethod == "DELETE") {
  if ($uid) {
    $userController->deleteUser($uid);
  } else {
    http_response_code(404);
    echo json_encode(["error" => "User id is missing"]);
  }
}
