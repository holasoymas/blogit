<?php
// controllers/userController.php
require_once '../models/blogModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';
require_once '../services/generateProfile.php';

class BlogController
{
  private $blogModel;

  public function __construct()
  {
    $db = new Database();
    $this->blogModel = new BlogModel($db);
  }

  public function createBlog($data)
  {
    $errors = [];

    SessionManager::startSession();
    $uid = SessionManager::getSession("uid");

    $title = $data["title"];
    $content = $data["content"];

    if (strlen($title) <= 10 || strlen($title) >= 255) {
      $errors["title"] = "Title must be of length between 10-255";
    }
    if (strlen($content) <= 100 || strlen($content) >= 65000) {
      $errors["content"] = "Content must be of length between 100-65000";
    }

    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode([
        "status" => 400,
        "errors" => $errors
      ]);
      return;
    }

    if (!SessionManager::isAuthenticated()) {
      http_response_code(401);
      echo  json_encode(["error" => "Please login first"]);
    }

    $blog = $this->blogModel->createBlog($title, $content, $uid);

    http_response_code(201);
    echo json_encode(["message" => "Blog created successfully", "blog" => $blog]);
  }
}
