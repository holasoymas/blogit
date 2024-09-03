<?php
// models/db.php
class Database
{
  private $host = 'localhost';
  private $dbname = 'blogit';
  private $username = 'root';
  private $password = '';
  private $pdo;

  public function connect()
  {
    try {
      $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this->pdo;
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
  }
}
