<?php
header('Content-Type: application/json');
require_once '../controllers/adminUserController.php';

$adminUser = new AdminUserController();

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
  case 'GET':
    $adminUser->getUsers();
    break;
  default:
    break;
}
