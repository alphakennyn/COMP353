<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check if the user can login
 * @return JSON login info
 */


function del_employee($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
    $id = $data['id'];


    $query1 = "DELETE payroll FROM payroll WHERE payroll.eid = ".$id.";";
    $query2 = "DELETE schedule FROM schedule WHERE schedule.eid = ".$id.";";
    $query3 = "DELETE worksat FROM worksat WHERE worksat.eid = ".$id.";";
    $query4 = "DELETE employee FROM employee WHERE employee.id = ".$id.";";

    $stmt1 = $db->prepare($query1);
    $stmt2 = $db->prepare($query2);
    $stmt3 = $db->prepare($query3);
    $stmt4 = $db->prepare($query4);

    $stmt1->execute();
    $stmt2->execute();
    $stmt3->execute();
    $stmt4->execute();

    return array("msg" => 'account deleted.');


    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

