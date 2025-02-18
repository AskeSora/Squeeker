<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Connection {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'squeeker';
    private $connection;
    
    public function __construct() {
        //echo "Creating a new Connection object...<br>"; // Debugging output
        $this->connect();
    }

    private function connect() {
        //echo "Attempting to connect to the database...<br>"; // Debugging output
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        } else {
            //echo "Database connection established successfully.<br>"; // Debugging output
        }
    }
 
    public function getConnection() {
        return $this->connection;
    }
}