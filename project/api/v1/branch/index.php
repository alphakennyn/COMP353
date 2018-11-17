<?php

/**  API /api/v1/branch */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'branch_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        return;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        echo json_encode(get_branch($id, JSON_FORCE_OBJECT));
        return;
    case 'PUT':
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;        
}