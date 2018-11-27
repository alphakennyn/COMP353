<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */

function get_payees()
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

        $query = "SELECT * FROM Payee;";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $packet = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($packet,$row);
        } 
        return $packet;
    } catch (Exception $e){
        return array("error" => "Server error ".$e." .");
    }
}

