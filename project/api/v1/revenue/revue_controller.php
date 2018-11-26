<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

function get_revenue_bank()
{
    try{
    $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

        $query = "Select a.sumhours*Employee.hourlyWage from (Select eid, SUM(a.hoursdiff) as sumhours from (select eid, startTime, endTime, TIMESTAMPDIFF(hour,startTime, endTime) as hoursdiff from Schedule ) as a) as a NATURAL JOIN Employee where a.eid = id;";


        $packet = array();

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}

function get_revenue_branch($branchId)
{

}

function get_revenue_city($cityName)
{

}

