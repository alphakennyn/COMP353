<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';


function del_account($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        $accNum = $data['accountNumber'];
        $cid = $data['cid'];

        $query0 = "DELETE Transactions FROM Transactions WHERE Transactions.accountNumber = ".$accNum." or Transactions.recipientAccountNumber = ".$accNum.";";
        $query1 = "DELETE Bills FROM Bills WHERE Bills.myPayeeId IN (SELECT MyPayee.id FROM MyPayee WHERE MyPayee.accountNumber = ".$accNum.");";
        $query2 = "DELETE MyPayee FROM MyPayee WHERE MyOayee.accountNumber = ".$accNum.";";
        $query3 = "DELETE AccountsOwned FROM AccountsOwned WHERE AccountsOwned.accountNumber = ".$accNum.";";
        $query5 = "DELETE AssociatedTo FROM AssociatedTo WHERE AssociatedTo.accountNumber = ".$accNum.";";
        $query4 = "DELETE Account FROM Account WHERE Account.accountNumber = ".$accNum.";";

        $stmt0 = $db->prepare($query0);   
        $stmt1 = $db->prepare($query1);
        $stmt2 = $db->prepare($query2);
        $stmt3 = $db->prepare($query3);
        $stmt5 = $db->prepare($query5);
        $stmt4 = $db->prepare($query4);

        $stmt0->execute();
        $stmt1->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt5->execute();
        $stmt4->execute();


        /**
        * GET account's updated data
        */
        $return_query = "SELECT Account.* ";
        $return_query .= "FROM AccountsOwned ";
        $return_query .= "INNER JOIN Clients ON id = cid ";
        $return_query .= "INNER JOIN Account on Account.accountNumber = AccountsOwned.accountNumber ";
        $return_query .= "WHERE Clients.id = ". $cid .";";

        $return_stmt = $db->prepare($return_query);
        $return_stmt->execute();
        $packet=array();
            
        while ($row = $return_stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($packet, $row);
        }

        return $packet;
    //return array($stmt0, $stmt1, $stmt2, $stmt3, $stmt4);

    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

