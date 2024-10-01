<?php

require_once '../models/likeModel.php';
require_once '../config/db.php';
require_once '../services/SessionManager.php';

class LikeController
{
  private $likeModel;

  public function __construct()
  {
    $db = new Database();
    $this->likeModel = new LikeModel($db);
  }


  public function toggleLike($pid)
  {
    $uid = SessionManager::getSession("uid");
    if (!$uid) {
      http_response_code(401);
      echo json_encode(["error" => "Login to like a post"]);
      exit;
    }
    try {
      // Check if the user has already liked the post
      $hasLiked = $this->likeModel->hasLikedPost($pid, $uid);

      if ($hasLiked) {
        // User has liked, so remove the like
        $this->likeModel->dislikePost($pid, $uid);
        $hasLiked = false;  // User now dislikes it
      } else {
        // User has not liked, so add the like
        $this->likeModel->likePost($pid, $uid);
        $hasLiked = true;  // User now likes it
      }
      // Retrieve the updated like count and status
      $currLikeStat = $this->likeModel->getLikesFromPost($pid);

      if ($currLikeStat) {
        http_response_code(201);
        echo json_encode([
          "like_count" => $currLikeStat["like_count"],
          "uids" => $currLikeStat["uids"],
          "hasLiked" => $hasLiked
        ]);
      } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to retrieve like status"]);
      }
    } catch (PDOException $e) {
      http_response_code(500);
      echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
    }
    exit;
  }

  public function getLikesFromPost($pid)
  {
    $uid = SessionManager::getSession("uid");

    $currLikeStat = $this->likeModel->getLikesFromPost($pid);
    $hasLiked = in_array($uid, $currLikeStat["uids"]);

    // Check if an error occurred while fetching likes
    if (isset($currLikeStat['error'])) {
      http_response_code(500); // Internal Server Error
      echo json_encode(["error" => $currLikeStat['error']]);
    }

    http_response_code(200);
    echo json_encode([
      "like_count" => $currLikeStat["like_count"],
      "uids" => $currLikeStat["uids"],
      "hasLiked" => $hasLiked
    ]);
  }
}
