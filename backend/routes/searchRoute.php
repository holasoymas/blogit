<?php

header("Content-Type: application/json");
require_once '../config/db.php';

$db = new Database();
$pdo = $db->connect();

$query = $_GET['query'] ?? ''; // Safely handle missing parameters
$query = "%$query%";

$sql = "
    SELECT fname AS suggestion FROM users WHERE fname LIKE :query OR lname LIKE :query
    UNION
    SELECT title AS suggestion FROM blogs WHERE title LIKE :query
    LIMIT 10
";

try {
  $stmp = $pdo->prepare($sql);
  $stmp->execute(["query" => $query]);

  $suggestions = $stmp->fetchAll(PDO::FETCH_COLUMN) ?: [];
  http_response_code(200);
  echo json_encode($suggestions);
} catch (Exception $e) {
  // Handle query errors or unexpected exceptions
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error"]);
}
