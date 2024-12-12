<?php
error_reporting(0);
class DBConnect {
    
    private $host = "localhost";
    private $user = "515557";
    private $pass = "123a456s1";
    private $dbname = "515557db2";
    private $conn;

    function __construct() {
        $this->conn = $this->connectDB();
    }

    function connectDB() {
        $conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
        return $conn;
    }
    function runQuery($query) {
        $result = mysqli_query($this->conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if (!empty($resultset))
        return $resultset;
    }
    function runAjaxQuery($query) {
        $result = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if (!empty($resultset))
            return json_encode($resultset);
    }
    function numRows($query) {
        $result = mysqli_query($this->conn, $query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }
}
?>
