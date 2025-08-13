<?php

class DbConnect
{
    var $host = "localhost";
    var $user = "root";
    var $password = "";
    var $database = "bbjewels";
    var $conn;
    var $error_reporting = false;

    function open() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            if ($this->error_reporting) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            return false;
        }
        return true;
    }

    function close() {
        return $this->conn->close();
    }

    function error() {
        if ($this->error_reporting) {
            return $this->conn->error;
        }
    }
}

class DbQuery
{
    var $conn;
    var $result = '';
    var $sql;

    function __construct($dbconnect, $sql1) {
        $this->conn = $dbconnect->conn;
        $this->sql = $sql1;
    }

    function query() {
        $this->result = $this->conn->query($this->sql);
        return $this->result;
    }

    function affectedrows() {
        return $this->conn->affected_rows;
    }

    function numrows() {
        return $this->result->num_rows;
    }

    function fetchobject() {
        return $this->result->fetch_object();
    }

    function fetcharray() {
        return $this->result->fetch_array(MYSQLI_ASSOC);
    }

    function fetchassoc() {
        return $this->result->fetch_assoc();
    }

    function freeresult() {
        return $this->result->free();
    }

    function close() {
        return $this->conn->close();
    }
}
?>
