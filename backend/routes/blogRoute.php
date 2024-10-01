<?php
// var_dump($_SERVER["REQUEST_METHOD"]);
// exit;
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header('Content-Type: application/json');
require_once '../controllers/blogController.php';
require_once '../services/SessionManager.php';

$blogController = new BlogController();

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
  case 'POST':
    // $data = json_decode(file_get_contents("php://input"), true);
    $blogController->createBlog();
    break;
  case 'GET':
    $blogController->getBlogById($pid);
  default:
    break;
}
