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

    $cpid = $account_data['cpid'];
    $irid = $account_data['irid'];
    $balance = $account_data['balance'];
    $transactionPerMonth = $account_data['transactionPerMonth'];
    $accountType = $account_data['accountType'];
    $maxPerDay = $account_data['maxPerDay'];
    $minBalance = ($account_data['minBalance'] == '' ? 'NULL' : $account_data['minBalance']);
    $businessNumber = ($account_data['businessNumber'] == '' ? 'NULL' : $account_data['businessNumber']);
    $taxId = ($account_data['taxId'] == '' ? 'NULL' : $account_data['taxId']);
    $creditLimit = ($account_data['creditLimit'] == '' ? 'NULL' : $account_data['creditLimit']);

    $query= "INSERT INTO ACCOUNT VALUES (0, $cpid, $irid, $balance, $transactionPerMonth, '$accountType', $maxPerDay, $minBalance, $businessNumber, $taxId, $creditLimit)";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->execute();

    $accountId = $db->lastInsertId();

    $cid = $account_data['cid'];
    $query2 = "INSERT INTO AccountsOwned VALUES ($cid, $accountId)";
    $stmt = $db->prepare($query2);
    $stmt->execute();

    // return latest account id
    return array("accountId" => $accountId);

  } catch (Exception $e) {
      return array("error" => "Server error ".$e." .");
  }
}