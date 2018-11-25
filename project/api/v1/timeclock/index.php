<?php

/**  API /api/v1/timeclock*/

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'timeclock_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        $eid = $_GET['id'];
        echo json_encode(get_timeclock($eid, JSON_FORCE_OBJECT));
        return;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(post_user_timeclock($data));
        return;
    case 'PUT':

        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;        
}