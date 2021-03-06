<?php   

/**  API /api/v1/login */

header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'login_controller.php';

$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method) {
    case 'GET':
        return;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $type = $data['type'];
        if ($type == 'client') {
            $cardNumber = $data['cardNumber'];
            $password = $data['password'];
            echo json_encode(is_valid_client($cardNumber, $password));
            return;
        } else {
            $employeeId = $data['employeeId'];
            $password = $data['password'];
            echo json_encode(is_valid_employee($employeeId, $password));
        }
    case 'PUT':
        return;
    default:
        echo json_encode(array("error" => 'Server error.'));
        return;
}
