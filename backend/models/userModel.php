<?php
// models/userModel.php
class UserModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function createUser($fname, $lname, $dob, $email, $password, $profile_pic)
  {
    $sql = "INSERT INTO users (fname,lname,dob, email, password, profile_pic) VALUES (:fname, :lname, :dob, :email, :password, :profile_pic)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['fname' => $fname, 'lname' => $lname, 'dob' => $dob, 'email' => $email, 'password' => $password, 'profile_pic' => $profile_pic]);
    // return $this->pdo->lastInsertId();
    // for sending user id 
    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $uuid = $stmt->fetchColumn();

    return $uuid;
  }

  public function getUserProfileById($uid)
  {
    try {
      $sql = "SELECT id, fname,lname, dob, email,profile_pic FROM users WHERE id = :uid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['uid' => $uid]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      $sql = "SELECT pid, uid, title, content FROM blogs WHERE uid = :uid";
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

  public function loginUser($email, $password)
  {
    $sql = "SELECT id FROM users WHERE email = :email AND password = :password";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);
    $uuid = $stmt->fetchColumn();
    return $uuid;
  }
}
