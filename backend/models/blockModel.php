<?php

class BlockModel
{
  private $pdo;

  public function __construct($db)
  {
    $this->pdo = $db->connect();
  }

  public function createBlock($sessionUser, $blockTo, $blockMsg)
  {
    $sql = "INSERT INTO blocks (block_by, block_to, message) VALUES(:block_by, :block_to, :msg)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['block_by' => $sessionUser, 'block_to' => $blockTo, 'msg' => $blockMsg]);

    $sql = "SELECT block_id FROM blocks WHERE block_to = :block_to AND block_by = :block_by";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['block_by' => $sessionUser, 'block_to' => $blockTo]);

    $block_id = $stmt->fetch(PDO::FETCH_ASSOC);

    return $block_id ? $block_id["block_id"] : null;
  }

  public function getBlock($sessionUser, $blockTo)
  {
    $sql = "SELECT block_id FROM blocks WHERE block_to = :block_to AND block_by = :block_by";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['block_by' => $sessionUser, 'block_to' => $blockTo]);

    $block_id = $stmt->fetch(PDO::FETCH_ASSOC);

    return $block_id ? $block_id["block_id"] : null;
  }
}
