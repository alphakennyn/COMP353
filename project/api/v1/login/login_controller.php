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
        $query = "SELECT * FROM Clients WHERE cardNumber = '".$cardNumber."' AND  pass = '".$password."'";

        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn();
        $stmt->execute();
        if ($number_of_rows > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $packet=array(
                    'login' => True,
                    'id' => $row['id'],
                    'pass' => $row['pass'],
                    'name' => $row['fullName'],
                    'category' => $row['phone'],
                    'email' => $row['email'],
                    'address' => $row['address'],
                    'joinDate' => $row['joinDate'],
                    'DOB' => $row['DOB'],
                    'cardNumber' => $row['cardNumber']
                );
            }
            return $packet;
        } else {
            return array("login" => False);
        }
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}


function is_valid_employee($employeeId, $password)
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

        // query statement
        $query = "SELECT * FROM Employee WHERE id = '".$employeeId."' AND  pass = '".$password."'";

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