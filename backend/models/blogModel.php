<?php

class BlogModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }


  public function createBlog($title, $content, $uid, $imageName)
  {
    try {
      $sql = "INSERT INTO blogs (title, content, uid, image) VALUES (:title, :content, :uid, :image)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([
        'title' => $title,
        'content' => $content,
        'uid' => $uid,
        'image' => $imageName
      ]);

      $sql = "SELECT pid FROM blogs WHERE title = :title AND content = :content AND uid = :uid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['title' => $title, 'content' => $content, 'uid' => $uid]);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result ? $result["pid"] : null;
    } catch (PDOException $e) {
      error_log("Database Error: " . $e->getMessage());
      http_response_code(500);
      echo json_encode(["error" => "Database error: " . $e->getMessage()]);
      return null;
    }
  }

  public function updateBlog($pid, $title, $content, $imageName)
  {
    try {

      $sql = "UPDATE blogs SET title = :title, content = :content, image = :image WHERE pid = :pid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['title' => $title, 'content' => $content, 'image' => $imageName, 'pid' => $pid]);
      return $pid;
    } catch (PDOException $e) {
      error_log("Database Error: " . $e->getMessage());
      http_response_code(500);
      echo json_encode(["error" => "Database error: " . $e->getMessage()]);
      return null;
    }
  }




  public function getBlogById($pid)
  {
    try {
      $sql = "SELECT b.*, u.fname, u.lname, u.email, u.profile_pic 
                    FROM blogs as b 
                    INNER JOIN users as u ON b.uid = u.id 
                    WHERE b.pid = :pid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['pid' => $pid]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result;
    } catch (PDOException $e) {
      error_log("Database error: " . $e->getMessage());
      return null;
    }
  }

  public function deleteBlog($pid)
  {
    try {
      // SQL query to delete the blog by its primary ID (pid)
      $sql = "DELETE FROM blogs WHERE pid = :pid";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['pid' => $pid]);

      // Check if any row was actually deleted
      if ($stmt->rowCount() > 0) {
        return $pid;
      } else {
        return null; // No blog found with the given ID
      }
    } catch (PDOException $e) {
      // Log the database error for debugging
      error_log("Database error during delete: " . $e->getMessage());
      return null;
    }
  }
}
