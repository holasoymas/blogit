<?php
// controllers/userController.php
require_once '../models/blockModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';

class BlockController
{
  private $blockModel;

  public function __construct()
  {
    $db = new Database();
    $this->blockModel = new BlockModel($db);
  }

  public function createBlock($data)
  {
    if (!SessionManager::isAuthenticated()) {
      http_response_code(401);
      echo  json_encode(["error" => "Please login first"]);
      exit;
    }

    $sessionUser = SessionManager::getSession("uid");

    $blockTo = $data["blockTo"];
    $blockMsg = $data["blockMsg"];

    $comment = $this->blockModel->createBlock($sessionUser, $blockTo, $blockMsg);
    http_response_code(201);
    echo json_encode($comment);
    exit;
  }
  public function getBlock($blockTo)
  {
    $sessUser = SessionManager::getSession("uid");
    $blockId = $this->blockModel->getBlock($sessUser, $blockTo);
    http_response_code(200);
    echo json_encode($blockId);
    exit;
  }
}
