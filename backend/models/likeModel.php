<?php

class LikeModel
{
  private $pdo;
  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function hasLikedPost($pid, $uid)
  {
    $sql = "SELECT uid FROM likes WHERE bid = :pid AND uid = :uid";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['pid' => $pid, 'uid' => $uid]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
  }

  public function likePost($pid, $uid)
  {
    $sql = "INSERT INTO likes (bid, uid) VALUES(:pid, :uid)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(["pid" => $pid, "uid" => $uid]);
  }

  public function dislikePost($pid, $uid)
  {
    $sql = "DELETE FROM likes WHERE bid = :pid AND uid = :uid";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['pid' => $pid, 'uid' => $uid]);
  }


  public function getLikesFromPost($pid)
  {
    try {
      // Prepare the SQL query to count likes and return user IDs as a comma-separated string
      $sql = "SELECT COUNT(uid) as like_count, GROUP_CONCAT(uid) as uids FROM likes WHERE bid = :pid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['pid' => $pid]); // Ensure the correct parameter key here
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      // Handle cases where no results are returned
      if ($result === false) {
        throw new Exception("No likes found for the given post ID.");
      }

      // Convert the comma-separated string into an array
      $uidsArray = $result['uids'] ? explode(',', $result['uids']) : [];

      return [
        'like_count' => (int)$result['like_count'], // Ensure like_count is an integer
        'uids' => $uidsArray  // Now an array of uids
      ];
    } catch (Exception $e) {
      error_log("Error fetching likes: " . $e->getMessage()); // Log the error
      return [
        'like_count' => 0,
        'uids' => [],
        'error' => $e->getMessage()
      ];
    }
  }
  //end of the module
}
