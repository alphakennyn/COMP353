<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */

function get_transactions($client_id)
{

    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
        //for testing
        //$client_id = 1;

        $packet = array();
        $query = "SELECT accountNumber FROM AccountsOwned WHERE cid = '" . $client_id . "'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $query = "SELECT t.* FROM Transactions t INNER JOIN AccountsOwned a ON a.accountNumber = t.accountNumber WHERE year(tStamp) > year(NOW())-10";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $packet[$row["accountNumber"]] = array();
            $query2 = $query . " AND t.accountNumber = '".$row["accountNumber"]."'";
            $stmt2 = $db->prepare($query2);
            $stmt2->execute();
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                array_push($packet[$row["accountNumber"]], $row2);
            }
        } 
        return $packet;
    } catch (Exception $e){
        return array("error" => "Server error ".$e." .");
    }
}
