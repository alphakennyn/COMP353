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

        $query = "SELECT * FROM Payroll WHERE eid = '".$eid."'";

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

function post_user_timeclock($data)
{

    try {
        $database = new Database();
        $db = $database->getConnection();
    
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        $eid = $data['eid'];
        $clockIn = $data['clockIn'];
        $clockOut = $data['clockOut'];

        $query = "INSERT INTO Payroll VALUES ($eid, '".$clockIn."', '".$clockOut."');";

        $stmt = $db->prepare($query);
        $stmt->execute();

        $query = "SELECT * FROM Payroll WHERE eid = '".$eid."'";
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
            return array("error" => 'Server Error');
        }
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

