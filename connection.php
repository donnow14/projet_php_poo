<?php

class Connection
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "project";
    public $conn;
    public function __construct()
    {   
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public  function execute($query){
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    function createTable($query)
    {
        if (mysqli_query($this->conn, $query)) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . mysqli_error($this->conn);
        }
    }
}

?>
