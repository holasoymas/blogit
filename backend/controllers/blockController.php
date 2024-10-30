<?php
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
      echo json_encode(["error" => "Please login first"]);
      exit;
    }

    $sessionUser = SessionManager::getSession("uid");

    $blockTo = $data["blockTo"];
    $blockMsg = $data["blockMsg"];

    try {
      $hasBlocked = $this->getBlock($blockTo);
      if ($hasBlocked) {
        http_response_code(409);
        echo json_encode(["error" => "You already blocked him/her"]);
        exit;
      }

      $block_id = $this->blockModel->createBlock($sessionUser, $blockTo, $blockMsg);
      if ($block_id) {
        http_response_code(201);
        echo json_encode(["block_id" => $block_id]);
      } else {
        throw new Exception("Failed to create block.");
      }
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => $e->getMessage()]);
    }
    exit;
  }


  public function getBlock($blockTo)
  {
    $sessionUser = SessionManager::getSession("uid");
    try {
      $blockId = $this->blockModel->getBlock($sessionUser, $blockTo);
      return $blockId;
    } catch (Exception $e) {
      throw new Exception("Error checking block: " . $e->getMessage());
    }
  }


  public function getBlockAndRespond($blockTo)
  {
    try {
      $blockId = $this->getBlock($blockTo);
      if ($blockId) {
        http_response_code(200);
        echo json_encode(["block_id" => $blockId]);
      } else {
        http_response_code(404);
        echo json_encode(["error" => "Not Block Yet"]);
      }
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => $e->getMessage()]);
    }
    exit;
  }
}
