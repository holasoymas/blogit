<?php
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

  public function updateUser($uid, $fname, $lname, $dob, $email, $password)
  {
    try {
      $sql = "UPDATE users 
            SET fname = :fname, lname = :lname, dob = :dob, email = :email, password = :password 
            WHERE id = :uid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['fname' => $fname, 'lname' => $lname, 'dob' => $dob,  'email' => $email, 'password' => $password, 'uid' => $uid]);
      return $uid;
    } catch (PDOException $e) {
      error_log("Database error: " . $e->getMessage());
      return null;
    }
  }

  public function getUserById($uid)
  {
    try {
      $sql = "SELECT id, fname,lname, dob, email,profile_pic FROM users WHERE id = :uid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['uid' => $uid]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      return $user;
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
    return $uuid ? $uuid : null;
  }

  public function deleteUser($uid)
  {
    $sql = "DELETE FROM users where id = :uid";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(["uid" => $uid]);

    if ($stmt->rowCount() > 0) {
      return ['message' => 'User deleted successfully'];
    } else {
      return ['error' => 'User not found or deletion failed'];
    }
  }
}
