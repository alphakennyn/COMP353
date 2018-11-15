<?php

/**  API /api/routes/clients.php */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once '../controllers/clients_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        $packet = get_all_clients();
        if (array_key_exists('error', $packet)) {
            echo json_encode(array("error" => $packet));
        } else {
            echo json_encode(array("data" => $packet));
        }
        return;
    case 'POST':
        return;
    case 'PUT':
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;
}
