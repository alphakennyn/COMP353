<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */


function pay_bills($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    foreach($data as $arr){
        $id = $arr['id'];
        $amount = $arr['amount'];
        $query = "SELECT Bills.amount FROM Bills WHERE Bills.id = ".$id.";";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $am = $row['amount'];
        }
    $total = $am - $amount;
    $query1 = "UPDATE Bills SET Amount = ".$total." WHERE Bills.id = ".$id.";";
    $stmt1 = $db->prepare($query1);
    $stmt1->execute();
    }
    return array("Updated Values" => True);
  

    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

