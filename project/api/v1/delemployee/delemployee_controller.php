<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

function del_employee($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
    $id = $data['id'];


    $query1 = "DELETE Payroll FROM Payroll WHERE Payroll.eid = ".$id.";";
    $query2 = "DELETE Schedule FROM Schedule WHERE Schedule.eid = ".$id.";";
    $query3 = "DELETE WorksAt FROM WorksAt WHERE WorksAt.eid = ".$id.";";
    $query4 = "DELETE Employee FROM Employee WHERE Employee.id = ".$id.";";

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
        return array("error" => "Server error");
    }
}

