<?php
class ProfileModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function getUserProfileById($uid)
  {
    try {
      $sql = "SELECT id, fname,lname, dob, email,profile_pic FROM users WHERE id = :uid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['uid' => $uid]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      $sql = "SELECT * FROM blogs WHERE uid = :uid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(["uid" => $uid]);
      $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $result = ["user" => $user, "blogs" => $blogs];
      return $result;
    } catch (PDOException $e) {
      // Log the error or output for debugging
      error_log("Database error: " . $e->getMessage());
      return null;
    }
  }
}
