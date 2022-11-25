<?php

class Database
{
    private $hostname = "mysql";
    private $db_name = "appDB";
    private $username = "user";
    private $password = "password";
    private $port = "3306";
    public $conn;

    public function getConnection(): mysqli
    {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->db_name, $this->port);
        mysqli_set_charset($this->conn, 'utf8');
        return $this->conn;
    }
}
