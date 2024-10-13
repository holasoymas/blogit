<?php

header('Content-Type: application/json');
require_once '../controllers/indexController.php';

$indexController = new IndexController();

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
  case 'GET':
    $indexController->getBlogs();
    break;
  default:
    break;
}
