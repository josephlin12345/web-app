<?php
  class Database {
    // db parameters
    private $host = 'i4010db.isrcttu.net:4010';
    private $dbname = 'I4010_9651';
    private $username = 'ui3b24';
    private $password = '0903926009';
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