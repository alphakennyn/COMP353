<?php

/**
 * Class to connect to database
 * Must setup database config from config.php
 */
class Database
{
    private $conn = null;
    private $host;
    private $db_name;
    private $username;
    private $password;

    public function __construct()
    {
        $configs = include("config.php");
        $this->host = $configs['host'];
        $this->db_name = $configs['db_name'];
        $this->username = $configs['username'];
        $this->password = $configs['password'];
    }

    /**
     * Get the connection of the database object
     * @return conn a database connection
     */
    public function getConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
