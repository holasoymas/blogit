<?php

include_once "../services/SessionManager.php";

SessionManager::startSession();

if (SessionManager::isAuthenticated()) {
  SessionManager::destroySession();
  http_response_code(200);
  echo json_encode(["status" => "success", "message" => "Logout Successful"]);
} else {
  http_response_code(400);
  echo json_encode([
    "status" => "error",
    "errors" => "Plz Login First to logout"
  ]);
  exit;
}
