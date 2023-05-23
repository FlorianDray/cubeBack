<?php
class DBConnection
{
    private $host = 'localhost';
    private $dbname = 'sneak_me';
    private $username = 'sylphe';
    private $password = 'Sylphe0597!';
    public $conn;

    public function connect()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }
}