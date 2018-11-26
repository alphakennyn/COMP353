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
    //For each data in array passed
    foreach($data as $arr){
        $id = $arr['id'];
        $amount = $arr['amount'];
        $accNum = $arr['accountNumber'];
        
        //get bill amount
        $query = "SELECT Bills.amount FROM Bills WHERE Bills.id = ".$id.";";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $am = $stmt->fetch(PDO::FETCH_ASSOC)['amount'];

        //get balance
        $query3 = "SELECT Account.balance FROM Account WHERE Account.accountNumber = ".$accNum.";";
        $stmt3 = $db->prepare($query3);
        $stmt3->execute();
        $balance = $stmt3->fetch(PDO::FETCH_ASSOC)['balance'];
        $total = $am - $amount;

        if ($balance > $amount){
            //Update new Bill amount
            $query1 = "UPDATE Bills SET Amount = ".$total." WHERE Bills.id = ".$id.";";
            $stmt1 = $db->prepare($query1);
            $stmt1->execute();

            //Update new Account Balance
            $left = $balance - $amount;
            $query6 = "UPDATE Account SET Account.balance = ".$left." WHERE Account.accountNumber = ".$accNum.";";
            $stmt6 = $db->prepare($query6);
            $stmt6->execute();

            //check if bill is now isPaid
            if ($total <= 0){
                $isP = 1;
                $query2 = "UPDATE Bills SET isPaid = ".$isP." WHERE Bills.id = ".$id.";";
                $stmt2 = $db->prepare($query2);
                $stmt2->execute();
            }
        } else {
            return array(
                "Bills Paid" => False,
                "Reason" => "Not Enough Funds");
        }
    }
    //Update Transactions Left
    $query4 = "SELECT Account.transactionsLeft FROM Account WHERE Account.accountNumber = ".$accNum.";";
    $stmt4 = $db->prepare($query4);
    $stmt4->execute();
    $tleft = $stmt4->fetch(PDO::FETCH_ASSOC)['transactionsLeft'];
    $tnew = $tleft - 1;
    $query5 = "UPDATE Account SET Account.transactionsLeft = ".$tnew." WHERE Account.accountNumber = ".$accNum.";";
    $stmt5 = $db->prepare($query5);
    $stmt5->execute();
    return array("Bills Paid" => True);
  

    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}
