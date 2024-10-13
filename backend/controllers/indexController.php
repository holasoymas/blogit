<?php

require_once '../models/indexModel.php';
require_once '../config/db.php';

class IndexController
{
  private $indexModel;

  public function __construct()
  {
    $db = new Database();
    $this->indexModel = new IndexModel($db);
  }

  public function getBlogs()
  {
    try {
      $blogs = $this->indexModel->getBlogs();
      if (!$blogs) {
        http_response_code(404);
        echo json_encode(['error' => "NO blogs found"]);
        exit;
      }

      $jsonResponse = json_encode($blogs);

      if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to encode JSON: ' . json_last_error_msg()]);
        exit;
      }

      http_response_code(200);
      echo $jsonResponse;
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => $e->getMessage()]);
    }
    exit;
  }
}
