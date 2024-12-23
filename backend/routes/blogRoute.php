<?php
// var_dump($_SERVER["REQUEST_METHOD"]);
// exit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once '../models/blogModel.php';
require_once '../services/SessionManager.php';
require_once '../config/db.php';
require_once '../controllers/blogController.php';

$pid = isset($_GET["pid"]) ? $_GET["pid"] : null;

$blogController = new BlogController();
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod === 'POST') {
  $db = new Database();
  $blogModel = new BlogModel($db);
  $errors = [];

  if (!SessionManager::isAuthenticated()) {
    http_response_code(401);
    echo json_encode(["error" => "Please login first"]);
    exit;
  }

  $uid = SessionManager::getSession("uid");

  $title = isset($_POST["title"]) ? $_POST["title"] : '';
  $content = isset($_POST["content"]) ? $_POST["content"] : '';
  $image = isset($_FILES['image']) ? $_FILES['image'] : null;

  // Validate title
  if (strlen($title) <= 10 || strlen($title) >= 255) {
    $errors["title"] = "Title must be between 10 and 255 characters.";
  }

  // Validate content
  if (strlen($content) <= 100 || strlen($content) >= 65000) {
    $errors["content"] = "Content must be between 100 and 65000 characters.";
  }
  // Validate image upload
  if (!$image || $image['error'] === UPLOAD_ERR_NO_FILE) {
    if (!isset($errors["image"])) {
      $errors["image"] = "Image is required.";
    }
  } else if ($image['error'] !== UPLOAD_ERR_OK) {
    if (!isset($errors["image"])) {
      $errors["image"] = "Error during file upload. Please try again.";
    }
  } else {
    // Additional image validation
    $allowed = ["jpg" => "image/jpg", "jpeg" => "image/jpeg", "webp" => "image/webp", "png" => "image/png"];
    $filename = $image["name"];
    $filetype = $image["type"];
    $filesize = $image["size"];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Check for valid file extension
    if (!array_key_exists($ext, $allowed)) {
      if (!isset($errors["image"])) { // Only set if no previous error
        $errors["image"] = "Invalid file format. Only JPG, JPEG, GIF, and PNG are allowed.";
      }
    }

    if (!in_array($filetype, $allowed)) {
      if (!isset($errors["image"])) { // Only set if no previous error
        $errors["image"] = "Invalid file MIME type.";
      }
    }

    // Check for file size limit
    $maxsize = 5 * 1024 * 1024; // 5MB
    if ($filesize > $maxsize) {
      if (!isset($errors["image"])) { // Only set if no previous error
        $errors["image"] = "File size exceeds the 5MB limit.";
      }
    }
  }

  // If there are errors, return all of them
  if (!empty($errors)) {
    http_response_code(400); // Bad Request
    echo json_encode(["errors" => $errors]);
    exit;
  }
  $new_filename = uniqid() . '.' . $ext;
  $upload_path = "uploads/" . $new_filename;

  // Create uploads directory if it doesn't exist
  if (!file_exists("uploads")) {
    mkdir("uploads", 0777, true);
  }

  // Save the file
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path)) {
    // Save the blog entry to the database
    $pid = $blogModel->createBlog($title, $content, $uid, $new_filename);

    if ($pid) {
      http_response_code(201);
      echo json_encode(["message" => "Blog created successfully", "pid" => $pid]);
      exit();
    } else {
      http_response_code(500);
      echo json_encode(["error" => "Error: Could not save to database."]);
    }
  } else {
    http_response_code(500);
    echo json_encode(["error" => "Error: Could not upload file."]);
  }
} else if ($requestMethod == 'GET') {
  $blogController->getBlogById($pid);
} else if ($requestMethod == 'DELETE') {
  $blogController->deleteBlog($pid);
} else if ($requestMethod == "PUT") {
  $db = new Database();
  $blogModel = new BlogModel($db);
  $errors = [];

  if (!SessionManager::isAuthenticated()) {
    http_response_code(401);
    echo json_encode(["error" => "Please login first"]);
    exit;
  }

  $uid = SessionManager::getSession("uid");

  $title = isset($_POST["title"]) ? $_POST["title"] : '';
  $content = isset($_POST["content"]) ? $_POST["content"] : '';
  $image = isset($_FILES['image']) ? $_FILES['image'] : null;

  // Validate title
  if (strlen($title) <= 10 || strlen($title) >= 255) {
    $errors["title"] = "Title must be between 10 and 255 characters.";
  }

  // Validate content
  if (strlen($content) <= 100 || strlen($content) >= 65000) {
    $errors["content"] = "Content must be between 100 and 65000 characters.";
  }
  // Validate image upload
  if (!$image || $image['error'] === UPLOAD_ERR_NO_FILE) {
    if (!isset($errors["image"])) {
      $errors["image"] = "Image is required.";
    }
  } else if ($image['error'] !== UPLOAD_ERR_OK) {
    if (!isset($errors["image"])) {
      $errors["image"] = "Error during file upload. Please try again.";
    }
  } else {
    // Additional image validation
    $allowed = ["jpg" => "image/jpg", "jpeg" => "image/jpeg", "webp" => "image/webp", "png" => "image/png"];
    $filename = $image["name"];
    $filetype = $image["type"];
    $filesize = $image["size"];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Check for valid file extension
    if (!array_key_exists($ext, $allowed)) {
      if (!isset($errors["image"])) { // Only set if no previous error
        $errors["image"] = "Invalid file format. Only JPG, JPEG, GIF, and PNG are allowed.";
      }
    }

    if (!in_array($filetype, $allowed)) {
      if (!isset($errors["image"])) { // Only set if no previous error
        $errors["image"] = "Invalid file MIME type.";
      }
    }

    // Check for file size limit
    $maxsize = 5 * 1024 * 1024; // 5MB
    if ($filesize > $maxsize) {
      if (!isset($errors["image"])) { // Only set if no previous error
        $errors["image"] = "File size exceeds the 5MB limit.";
      }
    }
  }

  // If there are errors, return all of them
  if (!empty($errors)) {
    http_response_code(400); // Bad Request
    echo json_encode(["errors" => $errors]);
    exit;
  }
  $new_filename = uniqid() . '.' . $ext;
  $upload_path = "uploads/" . $new_filename;

  // Create uploads directory if it doesn't exist
  if (!file_exists("uploads")) {
    mkdir("uploads", 0777, true);
  }

  // Save the file
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path)) {
    // Save the blog entry to the database
    $pid = $blogModel->updateBlog($pid, $title, $content, $new_filename);

    if ($pid) {
      http_response_code(201);
      echo json_encode(["message" => "Blog updated successfully", "pid" => $pid]);
      exit();
    } else {
      http_response_code(500);
      echo json_encode(["error" => "Error: Could not save to database."]);
    }
  } else {
    http_response_code(500);
    echo json_encode(["error" => "Error: Could not upload file."]);
  }
} else {
  http_response_code(405);
  echo json_encode(["error" => "Method not allowed"]);
}
