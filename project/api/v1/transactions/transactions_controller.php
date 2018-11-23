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
        //$acc_num = 3;
        $query = "SELECT * FROM TRANSACTIONS WHERE accountNumber = '".$acc_num."'";

        $stmt = $db->prepare($query);
        $stmt->execute();

        $packet = array();
        $packet["account_transactions"]=array();

        $number_of_rows = $stmt->fetchColumn();
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($packet["account_transactions"],$row);
        } 

        $query = "SELECT TransactionsPerMonth, TransactionsLeft FROM Account WHERE accountNumber = '".$acc_num."'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $transactionData = $stmt->fetch(PDO::FETCH_ASSOC);
        $packet["transactions_left"] = $transactionData["TransactionsPerMonth"];
        $packet["transactions_pm"] = $transactionData["TransactionsLeft"];

        return $packet;
    } catch (Exception $e){
        return array("error" => "Server error ".$e." .");
    }
}

