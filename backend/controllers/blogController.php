<?php
require_once '../models/blogModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';
require_once '../services/generateProfile.php';

class BlogController
{
  private $blogModel;
  private $imageUpload;

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
      echo json_encode(["error" => "Please login first"]);
      exit;
    }

    $uid = SessionManager::getSession("uid");
    $title = isset($_POST["title"]) ? $_POST["title"] : '';
    $content = isset($_POST["content"]) ? $_POST["content"] : '';

    // Validate inputs
    if (strlen($title) <= 10 || strlen($title) >= 255) {
      $errors["title"] = "Title must be of length between 10-255";
    }
    if (strlen($content) <= 100 || strlen($content) >= 65000) {
      $errors["content"] = "Content must be of length between 100-65000";
    }
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
      $errors["image"] = "Image is required";
    }

    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode(["errors" => $errors]);
      exit;
    }

    try {
      // Upload image
      $imageName = $this->imageUpload->upload($_FILES['image']);

      // Create blog with image
      $blogId = $this->blogModel->createBlog($title, $content, $uid, $imageName);

      if (!$blogId) {
        throw new Exception("Failed to create blog");
      }

      http_response_code(201);
      echo json_encode([
        "message" => "Blog created successfully",
        "blog" => $blogId
      ]);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => $e->getMessage()]);
    }
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


  function deleteBlog($pid)
  {
    // Get the logged-in user's ID
    $uid = SessionManager::getSession("uid");
    $admin = SessionManager::getSession("admin");

    if (!$uid) {
      http_response_code(401);
      echo json_encode(["error" => "Please login to delete the blog"]);
      exit;
    }

    // Fetch the blog by its ID to verify ownership
    $blog = $this->blogModel->getBlogById($pid);

    if (!$blog) {
      http_response_code(404);
      echo json_encode(["error" => "Blog not found"]);
      exit;
    }

    if (!$admin && $blog['uid'] != $uid) {
      http_response_code(403);
      echo json_encode(["error" => "Unauthorized: You do not have permission to delete this blog"]);
      exit;
    }

    $blogdata = $this->blogModel->deleteBlog($pid);
    if (!$blogdata) {
      http_response_code(500);
      echo json_encode(["error" => "Failed to delete the blog"]);
      exit;
    }
    http_response_code(200);
    echo json_encode(["message" => "Blog deleted successfully", "loggedInUser" => $uid, "blog" => $blogdata]);
    exit;
  }
}
