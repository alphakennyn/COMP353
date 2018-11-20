<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Send moulas
 * @param sender sender's account number 
 * @param recipient recipient's account number 
 * @param amount $$$ 
 */
function send_transfer($sender,$recipient, $amount)
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
        $check_query = "SELECT * FROM ACCOUNT ";
        $check_query .= "WHERE accountNumber = ".$recipient.";";

        $check_stmt = $db->prepare($check_query);
        $check_stmt->execute();

        if ($check_stmt->fetch(PDO::FETCH_ASSOC) == false) {
            return array("error" => "Account does not exist. >:(");
        }

        // query statement
        $query = "UPDATE ACCOUNT "; 
        $query .= "SET balance = balance + ".$amount." ";
        $query .= "WHERE accountNumber = ".$recipient.";";
        
        // // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        $query1 = "UPDATE ACCOUNT "; 
        $query1 .= "SET balance = balance - ".$amount." ";
        $query1 .= "WHERE accountNumber = ".$sender.";";

        // // prepare query statement
        $stmt1 = $db->prepare($query1);
        $stmt1->execute();
        
        $query2 = "SELECT balance FROM ACCOUNT "; 
        $query2 .= "WHERE accountNumber = ".$sender.";";

        $stmt2 = $db->prepare($query2);
        $stmt2->execute();

        return $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}
