<?php

class AdminUserModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function getUsers()
  {
    $sql = "
      SELECT
      u.id AS id,
      u.fname AS fname,
      u.lname AS lname,
      u.email AS email,
      COUNT(DISTINCT blk.block_id) AS block_req_nums
      FROM
      users u
      LEFT JOIN
      blocks blk ON blk.block_to = u.id
      GROUP BY
       u.id,u.fname,u.lname,u.email
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    // Fetch all users
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return !empty($users) ? $users : null;
  }
}
