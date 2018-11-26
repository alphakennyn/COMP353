<?php
include_once '../../database/database.php';
include_once '../../utils/helpers.php';

/**
 * Get Bank information
 * @return JSON information regarding bank
 */
function get_bank() {
{
    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!test_db_connection($db)) {
            return array("error" => "Cannot connect to DB.");
        }
    
        // query statement
        $query = "SELECT * FROM Bank";
    
        // prepare query statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $packet=array(
                'bankName' => $row['bankName'],
                'hqLocation' => $row['hqLocation'],
                'president' => $row['president'],
                'investManager' => $row['investManager'],
                'insureManager' => $row['insureManager'],
                'bankManager' => $row['bankManager']
                );
            }
            return $packet;
        } catch (Exception $e) {
            return array("error" => "Server error ".$e." .");
        }
    }
}
