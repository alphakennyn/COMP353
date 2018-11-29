<?php

/**  API /api/v1/bills */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'bills_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        // $data = json_decode(file_get_contents('php://input'), true);
        $account = $_GET['accountNumber'];
        echo json_encode(print_bills($account));
        return;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(toggle_autopay($data));
        return;
    case 'PUT':
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;
}
