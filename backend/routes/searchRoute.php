<?php
header("Content-Type: application/json");
require_once '../config/db.php';

$db = new Database();
$pdo = $db->connect();
$query = $_GET['query'] ?? '';
$query = "%$query%";

$sql = "
    SELECT 'uid' as type,id as id, fname as text 
    FROM users 
    WHERE fname LIKE :query OR lname LIKE :query
    UNION
    SELECT 'pid' as type, pid as id, title as text 
    FROM blogs 
    WHERE title LIKE :query
    LIMIT 10
";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute(["query" => $query]);
  $suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  echo json_encode($suggestions);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error"]);
}
