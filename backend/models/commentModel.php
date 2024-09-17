<?php

class CommentModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function createComment($pid, $uid, $comment)
  {
    $sql = "INSERT INTO comments (blog_id, user_id, comment) VALUES(:blog_id, :user_id, :comment)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['blog_id' => $pid, 'user_id' => $uid, 'comment' => $comment]);

    // After insertion, select all comments for the specific blog_id
    $sql = "SELECT * FROM comments WHERE blog_id = :blog_id ORDER BY created_at DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['blog_id' => $pid]);

    // Fetch all comments
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the fetched comments
    return $comments ? $comments : null;
  }

  public function getCommentsByBlog($pid)
  {
    $sql = "SELECT * FROM comments WHERE blog_id = :blog_id ORDER BY created_at DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['blog_id' => $pid]);

    // Fetch all comments
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the fetched comments
    return $comments ? $comments : null;
  }
}
