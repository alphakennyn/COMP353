<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */

function get_transactions($acc_num)
{

    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

        $query = "SELECT * FROM TRANSACTIONS WHERE accountNumber = '".$acc_num."'";

        $packet = array();

        $stmt = $db->prepare($query);
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn();
        $stmt->execute();
        if ($number_of_rows > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $tmp = array(
                    'bid' => $row['bid'],
                    'accountNumber' => $row['accountNumber'],
                    'transType' => $row['transType'],
                    'amount' => $row['amount'],
                    'transNumber' => $row['transNumber'],
                    'tStamp' => $row['tStamp']
                );
                array_push($packet,$tmp);
            } 
            return $packet;
        } else{
            return array("accNumExists" => False);
        }
    } catch (Exception $e){
        return array("error" => "Server error ".$e." .");
    }
}

