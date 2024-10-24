<?php

header('Content-Type: application/json');
require_once '../controllers/profileController.php';

$profileController = new ProfileController();

$uid = isset($_GET['uid']) ? $_GET['uid'] : null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'GET') {
  if ($uid) {
    $profileController->getUserProfileById($uid);
  } else {
    echo json_encode(["error" => "User ID (uid) is missing"]);
  }
}
