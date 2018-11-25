<?php

/**  API /api/v1/schedule */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'schedule_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        $eid = $_GET['eid'];
        echo json_encode(get_schedule($eid, JSON_FORCE_OBJECT));
        return;
    case 'POST':

        return;
    case 'PUT':
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;        
}