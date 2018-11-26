<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */


function del_account($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
    $accNum = $data['accountNumber'];



    $query0 = "DELETE transactions FROM transactions WHERE transactions.accountNumber = ".$accNum." or transactions.recipientAccountNumber = ".$accNum.";";
    $query1 = "DELETE bills FROM bills WHERE bills.myPayeeId IN (SELECT mypayee.id FROM mypayee WHERE mypayee.accountNumber = ".$accNum.");";
    $query2 = "DELETE mypayee FROM mypayee WHERE mypayee.accountNumber = ".$accNum.";";
    $query3 = "DELETE accountsOwned FROM accountsOwned WHERE accountsOwned.accountNumber = ".$accNum.";";
    $query4 = "DELETE account FROM account WHERE account.accountNumber = ".$accNum.";";

    $stmt0 = $db->prepare($query0);   
    $stmt1 = $db->prepare($query1);
    $stmt2 = $db->prepare($query2);
    $stmt3 = $db->prepare($query3);
    $stmt4 = $db->prepare($query4);

    $stmt0->execute();
    $stmt1->execute();
    $stmt2->execute();
    $stmt3->execute();
    $stmt4->execute();


    return array($stmt0, $stmt1, $stmt2, $stmt3, $stmt4);


    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

