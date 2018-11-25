<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';


function get_all_employees()
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        // query statement
        $query = "SELECT * FROM EMPLOYEE";
    
        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        $packet=array();
        $packet["employee"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tmp=array(
                "id" => $row['id'],
                "category" => $row['category'],
                "phone" => $row['phone'],
                "title" => $row['title'],
                "name" => $row['fullName'],
                "hourlyWage" => $row['hourlyWage'],
                "startDate" => $row['startDate'],
                "availableSick" => $row['availableSick'],
                "availableHoliday" => $row['availableHoliday']
            );
            array_push($packet["employee"], $tmp);
        }
        return $packet;
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}


function get_employee_by_id($employee_id)
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        // query statement
        $query = "SELECT * FROM EMPLOYEE WHERE id = ".$employee_id.";";
    
        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        $packet = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$packet) {
            return array("error" => "Incorrect login info.");
        } 
        unset($packet['id']);
        unset($packet['pass']);

        return $packet;
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}