<?php

class BlogModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function createBlog($title, $content, $uid)
  {
    $sql = "INSERT INTO blogs (title,content,uid) VALUES (:title, :content, :uid)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['title' => $title, 'content' => $content, 'uid' => $uid]);

    // for sending blog 
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result : null;
  }
}
