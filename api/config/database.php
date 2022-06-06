<?php
  class Database {
    // db parameters
    private $host = '';
    private $dbname = '';
    private $username = '';
    private $password = '';
    private $conn;

    // connect to db
    public function connect() {
      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->conn;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }
  }
?>
