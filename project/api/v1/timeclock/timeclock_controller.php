<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';


function get_timeclock($eid)
{

    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

        $query = "SELECT * FROM payroll WHERE eid = '".$eid."'";

        $packet = array();

        $stmt = $db->prepare($query);
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn();
        $stmt->execute();
        if ($number_of_rows > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $tmp = array(
                    'employeeExists' => True,
                    'eid' => $row['eid'],
                    'clockIn' => $row['clockIn'],
                    'clockOut' => $row['clockOut']
                );
                array_push($packet,$tmp);
            } 
            return $packet;
        } else{
            return array("employeeExists" => False);
        }
    } catch (Exception $e){
        return array("error" => "Server error ".$e." .");
    }
}

