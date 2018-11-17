<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Query all accounts information
 * @return JSON information regarding clients
 */
function get_all_accounts()
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        // query statement
        $query = "SELECT * FROM ACCOUNT";
    
        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        $packet=array();
        $packet["accounts"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tmp=array(
                "accountNumber" => $row['accountNumber'],
                "cpid" => $row['cpid'],
                "irid" => $row['irid'],
                "balance" => $row['balance'],
                "transactionsPerMonth" => $row['transactionsPerMonth'],
                "accountType" => $row['accountType'],
                "maxPerDay" => $row['maxPerDay'],
                "minBalance" => $row['minBalance'],
                "businessNumber" => $row['businessNumber'],
                "taxId" => $row['taxId'],
                "creditLimit" => $row['creditLimit']
            );
            array_push($packet["accounts"], $tmp);
        }
        return $packet;
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

function get_user_accounts($user_id)
{
  try {
    $database = new Database();
    $db = $database->getConnection();

    if (!test_db_connection($db)) {
        return array("error" => "Cannot connect to DB.");
    }

    // query statement
    $query = "SELECT ACCOUNT.*, cid FROM AccountsOwned INNER JOIN CLIENTS ON id = cid INNER JOIN ACCOUNT on ACCOUNT.accountNumber = AccountsOwned.accountNumber WHERE cid = ". $user_id .";";
    //echo $query;
    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->execute();

    $packet=array();
    $packet["user_accounts"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      // $tmp=array();
      array_push($packet["user_accounts"], $row);
    }
    return $packet;
  } catch (Exception $e) {
      return array("error" => "Server error ".$e." .");
  }
}

function post_user_accounts($account_data)
{
  try {
    $database = new Database();
    $db = $database->getConnection();

    if (!test_db_connection($db)) {
        return array("error" => "Cannot connect to DB.");
    }

    $query = "INSERT INTO Account VALUES";
    $query .= "(".$account_data['cpid']."";
    $query .= ",".$account_data['irid']."";
    $query .= ",".$account_data['balance']."";
    $query .= ",".$account_data['transactionsPerMonth']."";
    $query .= ",".$account_data['accountType']."";
    $query .= ",".$account_data['maxPerDay']."";
    $query .= ",".$account_data['minBalance']."";
    $query .= ",".$account_data['businessNumber']."";
    $query .= ",".$account_data['taxId']."";
    $query .= ",".$account_data['creditLimit'].");";

    
    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->execute();

    $accountId = $db->lastInsertId();
    echo $accountId;
    
    // $query2 = "INSERT INTO AccountsOwned VALUES";
    // $query2 .= "(".$account_data['cid'].",";
    // $query2 .= "".$account_data['']
    return $resp;

    //return "New record created successfully";
  } catch (Exception $e) {
      return array("error" => "Server error ".$e." .");
  }
}