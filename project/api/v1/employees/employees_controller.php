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
       $query = "select * from(Select Branch.phone, Branch.fax, Branch.location, Branch.city, Branch.openingDate, Branch.revenue, Branch.managerId, Employee.category, Employee.ephone, Employee.title, Employee.fullName, Employee.address, Employee.hourlyWage, Employee.startDate, Employee.availableSick, Employee.availableHoliday, Employee.pass, Employee.bid, Employee.eid from Branch inner JOIN  (select Employee.category, Employee.ephone , Employee.title, Employee.fullName, Employee.address, Employee.hourlyWage, Employee.startDate, Employee.availableSick, Employee.availableHoliday, Employee.pass, WorksAt.bid, WorksAt.eid from (select id, category, phone as ephone, title, fullName, address, hourlyWage, startDate, availableSick, availableHoliday, pass from Employee) as Employee inner JOIN WorksAt where WorksAt.eid = Employee.id) as Employee where Employee.bid = Branch.id) as a where eid =".$employee_id.";";
       
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

function modify_employee_by_id($user)
{
    try {
        $database = new Database();
        $db = $database->getConnection();
        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
        
        $query = "UPDATE Employee SET phone = '".$user['ephone']."' , address = '".$user['address']."' WHERE id = ".$user['eid']."";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return array("msg" => 'Successfully updated client info.');
        
    } catch (Exceptiion $e) {
        return array("error" => "Server error ".$e." .");
    }
}
