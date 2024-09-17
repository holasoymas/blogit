<?php
// controllers/userController.php
require_once '../models/commentModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';

class CommentController
{
  private $commentModel;

  public function __construct()
  {
    $db = new Database();
    $this->commentModel = new CommentModel($db);
  }

  public function createComment($data)
  {

    SessionManager::startSession();

    // SessionManager::destroySession();

    if (!SessionManager::isAuthenticated()) {
      http_response_code(401);
      echo  json_encode(["error" => "Please login first"]);
      exit;
    }

    $uid = SessionManager::getSession("uid");

    $comment = $data["comment"];
    $pid = $data["pid"];

    $comment = $this->commentModel->createComment($pid, $uid, $comment);
    http_response_code(201);
    echo json_encode($comment);
    exit;
  }
  public function getCommentsByBlog($pid)
  {
    $comments = $this->commentModel->getCommentsByBlog($pid);
    http_response_code(200);
    echo json_encode($comments);
    exit;
  }
}
