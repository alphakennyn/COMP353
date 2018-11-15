<?php
include_once '../database/database.php';
include_once '../utils/helpers.php';

/**
 * Query all clients information
 * @return JSON information regarding clients
 */
function get_all_clients()
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        // query statement
        $query = "SELECT fullName, email FROM CLIENTS";
    
        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        $packet=array();
        $packet["clients"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tmp=array(
                "name" => $row['fullName'],
                "email" => $row['email']
            );
            array_push($packet["clients"], $tmp);
        }
        return $packet;
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}
