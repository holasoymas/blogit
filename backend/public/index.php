// <?php
// $requestUri = $_SERVER['REQUEST_URI'];
// $requestMethod = $_SERVER['REQUEST_METHOD'];

// if ($requestUri == '/blogit/backend/public/index.php/api/users' && $requestMethod == 'POST') {
//     require_once '../controllers/UserController.php';
//     $userController = new UserController();
//     $userController->create();
// } else {
//     http_response_code(404);
//     echo json_encode(['message' => 'Not Found']);
// }

<?php

header('Content-Type: application/json');
echo json_encode(['message' => 'Test successful']);
