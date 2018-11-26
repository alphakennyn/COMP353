<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Check branch information
 * @return JSON login info
 */
function get_branch($id)
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }

    //query statement
    $query = "SELECT * FROM Branch WHERE id = '".$id."'";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $number_of_rows = $stmt->fetchColumn();
    $stmt->execute();
    if ($number_of_rows > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $packet = array (
                'branchExists' => True,
                'id' => $row['id'],
                'phone' => $row['phone'],
                'fax' => $row['fax'],
                'location' => $row['location'],
                'city' => $row['city'],
                'openingDate' => $row['openingDate'],
                'revenue' => $row['revenue'],
                'managerId' => $row['managerId']
            );
            return $packet;
            }
        } else{
            return array("branchExists" => False);
        }
    } catch (Exception $e) {
        return array("error" => "Server error ".$e." .");
    }
}


