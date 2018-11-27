<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */


function del_client($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

        $id = $data['id'];
        /**
         * Check if user exist
         */
        $check_query = "SELECT * FROM AccountsOwned ";
        $check_query .= "WHERE accountNumber = ".$id.";";

        $check_stmt = $db->prepare($check_query);
        $check_stmt->execute();

        if ($check_stmt->fetch(PDO::FETCH_ASSOC) != false) {
            $error=array();
            $error["result"]= False;
            $error["message"]= "You can't delete client since they still have an active account.";

            return $error;
        }


        $query1 = "DELETE FROM Member WHERE Member.cid = ".$id.";";
        $query2 = "DELETE FROM Clients WHERE Clients.id = ".$id.";";

        $stmt1 = $db->prepare($query1);   
        $stmt2 = $db->prepare($query2);

        $stmt1->execute();
        $stmt2->execute();

        return array("result" => True);

    } catch (Exception $e) {
        return array("result" => False);
    }
}

