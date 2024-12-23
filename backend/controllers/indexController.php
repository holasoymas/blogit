<?php

require_once '../models/indexModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';

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
      $res = [
        "blogs" => $blogs,
        "loggedInUser" => SessionManager::getSession("uid"),
      ];

      http_response_code(200);
      echo json_encode($res);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => $e->getMessage()]);
    }
    exit;
  }
}
