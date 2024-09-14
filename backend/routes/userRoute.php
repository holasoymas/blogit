<?php
// var_dump($_SERVER["REQUEST_METHOD"]);
// exit;
header('Content-Type: application/json');
require_once '../controllers/userController.php';

$userController = new UserController();

$uid = isset($_GET['uid']) ? $_GET['uid'] : null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $userController->createUser($data);
}

if ($requestMethod == 'GET') {
  // var_dump($_SERVER["REQUEST_METHOD"]);
  // exit;

  if ($uid) {
    $userController->getUserById($uid);
  } else {
    echo json_encode(["error" => "User ID (uid) is missing"]);
  }
}
