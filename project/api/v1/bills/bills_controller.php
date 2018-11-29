<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */

function print_bills($accNum)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
        
        $packet = array();
        $query = "SELECT MyPayee.id FROM MyPayee INNER JOIN Account ON MyPayee.accountNumber = Account.accountNumber WHERE MyPayee.accountNumber = ".$accNum." AND Account.accountNumber = ".$accNum.";";
        $stmt = $db->prepare($query); 
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn();
        $stmt->execute();


        if ($number_of_rows > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $query1 = "SELECT accountNumber, autoPay, payeeId, isPaid, dueDate, MyPayee.amount as MyPayeeAmount, Bills.amount as billsAmount, Bills.id as billsId FROM MyPayee INNER JOIN Bills ON MyPayee.id = Bills.MyPayeeId WHERE MyPayee.id = ".$id." AND Bills.MyPayeeId = ".$id.";";
                $stmt1 = $db->prepare($query1);
                $stmt1->execute();
                $number_of_rows1 = $stmt1->fetchColumn();
                $stmt1->execute();
                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    array_push($packet, $row1);
                }
                return $packet;
            }
        } else {
                return array("billExists" => False);
        }

    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

function toggle_autopay($bill_id){
    try {
        $database = new Database();
        $db = $database->getConnection();
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
        $query = "UPDATE Bills SET autoPay = NOT autoPay WHERE id = '" . $bill_id . "'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $query = "SELECT autoPay FROM Bills WHERE id = '" . $bill_id . "'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exceptiion $e) {
        return array("error" => "Server error ".$e." .");
    }
}