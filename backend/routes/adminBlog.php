<?php
ini_set('display_errors', 1); // Display errors on the page
ini_set('display_startup_errors', 1); // Show startup errors
error_reporting(E_ALL); // Report all errors

header("Content-Type: application/json");
require_once '../config/db.php';
require_once '../services/SessionManager.php';

$request_method = $_SERVER["REQUEST_METHOD"];

$db = new Database();
$pdo = $db->connect();


if ($request_method == "GET") {
  SessionManager::setSession("admin", "admin123");
  $sql = "SELECT reported_blog, reported_by, report_reason, count(reported_by) AS no_of_reports FROM `report_blogs` GROUP by reported_blog";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $blogdata = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    http_response_code(200);
    echo json_encode($blogdata);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Inter database error", "details" => $e->getMessage()]);
  }
}
