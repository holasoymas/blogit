<?php

header('Content-Type:application/json');
require_once '../controllers/likeController.php';


$likeController = new LikeController();

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'POST') {
  // Read JSON input
  $input = json_decode(file_get_contents('php://input'), true);
  $pid = isset($input['postId']) ? $input['postId'] : null;

  if ($pid) {
    $likeController->toggleLike($pid);
  } else {
    // Handle error, no postId found
    echo json_encode(['error' => 'postId is missing']);
    http_response_code(400); // Bad Request
  }
}


if ($requestMethod == 'GET') {
  $likeController->getLikesFromPost($pid);
  exit;
}
