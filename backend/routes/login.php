<?php
header('Content-Type: application/json');
require_once '../controllers/userController.php';

$userController = new UserController();

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $userController->loginUser($data);
}
