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

        // // query statement
        $query = "UPDATE ACCOUNT "; 
        $query .= "SET balance = balance + ".$amount." ";
        $query .= "WHERE accountNumber = ".$recipient.";";
        
        // // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        $query1 = "UPDATE ACCOUNT "; 
        $query1 .= "SET balance = balance + ".$amount." ";
        $query1 .= "WHERE accountNumber = ".$sender.";";

        // // prepare query statement
        $stmt1 = $db->prepare($query1);
        $stmt1->execute();
        
        $query2 = "SELECT amount FROM ACCOUNT "; 
        $query2 .= "WHERE accountNumber = ".$sender.";";

        $stmt2 = $db->prepare($query1);
        $stmt2->execute();

        $packet=array();

        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            array_push($packet["balance"], $row);
        }

        return array("balance" => $packet);
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}
