<?php

/**  API /api/v1/clients */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'accounts_controller.php';
$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        $user_id = $_GET['user_id'];
        $user_email = $_GET['user_email'];

        if ($user_email != null) {
            $packet = get_accounts_by_email($user_email);
        } else {
            $packet = get_user_accounts($user_id);
        }
        echo json_encode($packet);
        return;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(post_user_accounts($data));
        return;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($data);
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;
}
