<?php

/**  API /api/v1/clients */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'clients_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        $user_id = $_GET['id'];
        
        if ($user_id != null) {
            $packet = get_client_by_id($user_id);
        } else {
            $packet = get_all_clients();
        }

        echo json_encode($packet);
        return;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        // changing passwords
        if (array_key_exists ('oldPass', $data) && array_key_exists ('newPass', $data)) {
            $packet = modify_client_password($data); 
        } else {
            $packet = modify_client_by_id($data);
        }
        echo json_encode($packet);
        return;
    case 'PUT':
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;
}
