<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */


function del_client($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
    $id = $data['id'];

    $query1 = "DELETE Member FROM Member WHERE Member.cid = ".$id.";";
    $query2 = "DELETE Clients FROM Clients WHERE Clients.id = ".$id.";";

    $stmt1 = $db->prepare($query1);   
    $stmt2 = $db->prepare($query2);


    return array($stmt1, $stmt2);


    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

