<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */
function is_valid_client($cardNumber, $password)
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

        // query statement
        $query = "SELECT * FROM CLIENTS WHERE cardNumber = '".$cardNumber."' AND  pass = '".$password."'";

        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn(); 
        if ($number_of_rows > 0) {
            return array("login" => True);
        } else {
            return array("login" => False);
        }
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}
