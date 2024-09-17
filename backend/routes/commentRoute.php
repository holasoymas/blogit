<?php
// var_dump($_SERVER["REQUEST_METHOD"]);
// exit;
header('Content-Type: application/json');
require_once '../controllers/commentController.php';
require_once '../services/SessionManager.php';

$commentController = new CommentController();

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;


$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
  case 'POST':
    $data = json_decode(file_get_contents("php://input"), true);
    $commentController->createComment($data);
    break;
  case 'GET':
    $commentController->getCommentsByBlog($pid);
  default:
    break;
}
