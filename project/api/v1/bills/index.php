<?php

/**  API /api/v1/bills */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'bills_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        return;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(print_bills($data));
        return;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($data);
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;
}
