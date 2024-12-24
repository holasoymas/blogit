<?php

class IndexModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function getBlogs()
  {
    try {
      $sql = "
        SELECT 
        b.pid AS blog_id, 
        b.title AS blog_title, 
        b.image AS blog_image,
        b.content AS blog_content, 
        b.created_at AS blog_created_at,
        COUNT(DISTINCT l.lid) AS blog_likes, 
        COUNT(DISTINCT c.cid) AS blog_comments
        FROM 
        blogs b
        LEFT JOIN 
        likes l ON b.pid = l.bid
        LEFT JOIN 
        comments c ON b.pid = c.blog_id
        GROUP BY 
        b.pid
        ORDER BY 
        b.created_at DESC
      ";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();
      $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return !empty($blogs) ? $blogs : null;
    } catch (PDOException $e) {
      throw new Exception("Database error: " . $e->getMessage());
    }
  }
}
