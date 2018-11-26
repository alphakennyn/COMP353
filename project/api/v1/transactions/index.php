<?php

/**  API /api/v1/transactions */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'transactions_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        $client_id= $_GET['clientID'];
        $packet = get_transactions($client_id);
        echo json_encode($packet);
        return;
    case 'POST':
        return;
    case 'PUT':
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;
}
