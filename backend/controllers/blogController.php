<?php
// controllers/userController.php
require_once '../models/blogModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';
require_once '../services/generateProfile.php';
require_once '../services/ImageUplaod.php';

class BlogController
{
  private $blogModel;

  public function __construct()
  {
    $db = new Database();
    $this->blogModel = new BlogModel($db);
  }

  public function createBlog()
  {
    $errors = [];

    if (!SessionManager::isAuthenticated()) {
      http_response_code(401);
      echo  json_encode(["error" => "Please login first"]);
      exit;
    }

    $uid = SessionManager::getSession("uid");

    $title = isset($_POST["title"]) ? $_POST["title"] : '';
    $content = isset($_POST["content"]) ? $_POST["content"] : '';

    if (strlen($title) <= 10 || strlen($title) >= 255) {
      $errors["title"] = "Title must be of length between 10-255";
    }
    if (strlen($content) <= 100 || strlen($content) >= 65000) {
      $errors["content"] = "Content must be of length between 100-65000";
    }

    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode([
        "errors" => $errors
      ]);
      exit;
    }

    $blogId = $this->blogModel->createBlog($title, $content, $uid);

    if (!$blogId) {
      echo json_encode(["error" => $blogId]);
      exit;
    }

    http_response_code(201);
    echo json_encode(["message" => "Blog created successfully", "blog" => $blogId]);
    exit;
  }

  function getBlogById($pid)
  {
    // note this is needed to know who is the owner
    $uid = SessionManager::getSession("uid");
    $blogdata = $this->blogModel->getBlogById($pid);
    if (!$blogdata) {
      http_response_code(404);
      echo json_encode(["error" => "Blog not found"]);
      exit;
    }
    http_response_code(200);
    echo json_encode(["loggedInUser" => $uid, "blog" => $blogdata]);
    exit;
  }
}
