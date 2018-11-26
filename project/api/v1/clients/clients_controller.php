<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

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
        $query = "SELECT fullName, email FROM Clients";
    
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


function get_client_by_id($user_id)
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        // query statement
        $query = "SELECT * FROM Clients WHERE id = ".$user_id.";";
    
        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $query1 = "SELECT ChargePlan.planoption as accountType,";
        $query1 .= " ChargePlan.planLimit as planLimit, ";
        $query1 .= " ChargePlan.charge as charge, ";
        $query1 .= " InterestRate.serviceType as serviceType, ";
        $query1 .= " InterestRate.percentCharge as percentCharge ";
        $query1 .= " FROM InterestRate INNER JOIN ChargePlan ON ChargePlan.id = InterestRate.id;";
    
        $stmt1 = $db->prepare($query1);
        $stmt1->execute();

        $packet=array();
        $packet["clients"]=array();
        $packet["plans"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            unset($row['id']);
            unset($row['pass']);
            array_push($packet["clients"], $row);
        }

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            array_push($packet["plans"], $row);
        }

        return $packet;
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}


function modify_client_by_id($user)
{
    try {
        error_reporting(0);
        $database = new Database();
        $db = $database->getConnection();
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
        
        $query = "SELECT id FROM Clients WHERE (email = '".$user['email']."' OR  phone = '".$user['phone']."') AND id <> ".$user[id]. "";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        if ($number_of_rows > 0) {
            return array("error" => 'Someone already has that email or phone number!'); 
        } else {
            $query = "UPDATE Clients SET phone = '".$user['phone']."' , email = '".$user['email']."' , address = '".$user['address']."' WHERE id = ".$user['id']."";
            $stmt = $db->prepare($query);
            $stmt->execute();
            return array("msg" => 'Successfully updated client info.');
        }
    } catch (Exceptiion $e) {
        return array("error" => "Server error ".$e." .");
    }
}


function modify_client_password($user)
{
    try {
        $database = new Database();
        $db = $database->getConnection();
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
         // query statement
         $query = "SELECT * FROM Clients WHERE id = '".$user['id']."' AND  pass = '".$user['oldPass']."'";
         $stmt = $db->prepare($query);
         $stmt->execute();
         $number_of_rows = $stmt->fetchColumn();
         // valid password
         if ($number_of_rows > 0) {
            $query = "UPDATE Clients SET pass = '".$user['newPass']."' WHERE id = ".$user['id']."";
            $stmt = $db->prepare($query);
            $stmt->execute();
            return array("msg" => "Successfully updated client info.");
         } else {
            return array("error" => "Incorrect password.");
         }
    } catch (Exceptiion $e) {
        return array("error" => "Server error ".$e." .");
    }
}