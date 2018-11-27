<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

//todo: add code to return the values from 
function get_revenue_bank()
{
    try{
    $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

       // $query = "Select a.sumhours*Employee.hourlyWage from (Select eid, SUM(a.hoursdiff) as sumhours from (select eid, startTime, endTime, TIMESTAMPDIFF(hour,startTime, endTime) as hoursdiff from Schedule ) as a) as a NATURAL JOIN Employee where a.eid = id;";
        $query = "SELECT SUM(revenue) as TotalRevenue FROM Branch;";

        $packet = array();

        $stmt = $db->prepare($query);
        $stmt->execute();
        //return $query; 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

function get_revenue_branch()
{
    try{
        $database = new Database();
            $db = $database->getConnection();
    
            if (!test_db_connection($db)) {
                return array("error" => "Cannot connect to DB.");
            }
    
            //$query = "Select bid, (revenue-annualWageExpense) as Profit from(Select hourlyWage, eid, bid, hoursWorked, revenue, SUM(hourlyWage*hoursWorked)*12 as annualWageExpense from (Select hourlyWage, eid , SUM(hoursdiff) as hoursWorked, bid from (Select hourlyWage, eid, bid from WorksAt Natural Join Employee where  id =eid) as a Natural Join (select eid, TIMESTAMPDIFF(hour,startTime, endTime) as hoursdiff from Schedule ) as b group by eid)as a Natural Join Branch where a.bid = Branch.id group by bid)as a;";    
            $query = "Select bid, (revenue-annualWageExpense) as Profit, city from(Select hourlyWage, eid, bid, hoursWorked, revenue, Branch.city, SUM(hourlyWage*hoursWorked)*12 as annualWageExpense from (Select hourlyWage, eid , SUM(hoursdiff) as hoursWorked, bid from (Select hourlyWage, eid, bid from WorksAt Natural Join Employee where  id =eid) as a Natural Join (select eid, TIMESTAMPDIFF(hour,startTime, endTime) as hoursdiff from Schedule ) as b group by eid)as a Natural Join Branch where a.bid = Branch.id group by bid)as a;";
            //$query = "SELECT * FROM Branch;";
            $stmt = $db->prepare($query);
            $stmt->execute();
            //$result = $stmt->fetchAll();
            
            $packet = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($packet, $row);
            }
            return $packet;
        }
        catch(Exception $e) {
            return array("error" => "Server error ".$e." .");
        }
}

function get_revenue_city($cityName)
{

}

