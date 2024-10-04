<?php
// var_dump($_SERVER["REQUEST_METHOD"]);
// exit;
header('Content-Type: application/json');
require_once '../controllers/blockController.php';

$blockController = new BlockController();

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
  case 'POST':
    $data = json_decode(file_get_contents("php://input"), true);
    $blockController->createBlock($data);
    break;
  case 'GET':
    $blockController->getBlock($blockTo);
  default:
    break;
}
