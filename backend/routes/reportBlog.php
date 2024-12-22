<?php

ini_set('display_errors', 1); // Display errors on the page
ini_set('display_startup_errors', 1); // Show startup errors
error_reporting(E_ALL); // Report all errors

header("Content-Type: application/json");
require_once '../config/db.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];

$db = new Database();
$pdo = $db->connect();

if ($requestMethod == "POST") {
  $data = json_decode(file_get_contents("php://input"), true);

  // Access the fields
  $reported_blog = $data['reported_blog'] ?? null;
  $reported_by = $data['reported_by'] ?? null;
  $report_reason = $data['report_reason'] ?? null;

  $sql = "INSERT INTO report_blogs (reported_blog, reported_by, report_reason)
  VALUES (:reported_blog, :reported_by, :report_reason)";

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["reported_blog" => $reported_blog, "reported_by" => $reported_by, "report_reason" => $report_reason]);
    http_response_code(201);
    echo json_encode(["msg" => "Block request send"]);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal server error", "details" => $e->getMessage()]);
  }
}
