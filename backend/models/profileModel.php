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
      // $sql = "SELECT id, fname,lname, dob, email,profile_pic,created_at FROM users WHERE id = :uid";
      // --Bug it this query  fix it 
      $sql = "
        SELECT 
        u.id AS id,
        u.fname AS fname,
        u.lname AS lname,
        u.dob AS dob,
        u.email AS email,
        u.profile_pic AS profile_pic,
        u.created_at AS created_at,
        COUNT(DISTINCT b.pid) AS blog_count,   
        COUNT(DISTINCT c.cid) AS comment_count,
        COALESCE(SUM(l.like_count), 0) AS total_likes
        FROM 
        users u
        LEFT JOIN 
          blogs b ON b.uid = u.id
        LEFT JOIN 
          comments c ON c.blog_id = b.pid
        LEFT JOIN 
          (SELECT bid, COUNT(lid) AS like_count FROM likes GROUP BY bid) l ON l.bid = b.pid 
        WHERE 
          u.id = :uid
        GROUP BY 
          u.id, u.fname, u.lname, u.dob, u.email, u.profile_pic, u.created_at
      ";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['uid' => $uid]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      $sql = "
        SELECT 
        b.pid AS blog_id, 
        b.title AS blog_title, 
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
        WHERE 
        b.uid = :uid 
        GROUP BY 
        b.pid
        ORDER BY 
        b.created_at DESC;
      ";
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
