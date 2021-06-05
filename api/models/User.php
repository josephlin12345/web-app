<?php
  class User {
    private $db_conn;

    public function __construct($db_conn) {
      $this->db_conn = $db_conn;
    }

    public function add($email, $name, $password) {
      $query = 'INSERT INTO users SET name=:name, password=:password, email=:email';
      try {
        $stmt = $this->db_conn->prepare($query);
        $success = $stmt->execute(
          array(
            ':email' => $email,
            ':name' => $name,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
          )
        );
        return $success;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function get($email) {
      $query = 'SELECT id, email, name, password, created_at, modified_at, valid FROM users WHERE email=:email';
      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute(array(':email' => $email));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function update($user, $avatar, $avatar_type, $name, $password) {
      $query = 'UPDATE users SET name=:name, modified_at=DEFAULT';
      $query .= $password ? ', password=:password' : '';
      $query .= $avatar ? ', avatar=:avatar, avatar_type=:avatar_type' : '';
      $query .= ' WHERE id=:id';

      $data = array(':name' => $name, ':id' => $user['id']);
      if($password) $data[':password'] = password_hash($password, PASSWORD_DEFAULT);
      if($avatar) {
        $data[':avatar'] = base64_decode($avatar);
        $data[':avatar_type'] = $avatar_type;
      }

      try {
        $stmt = $this->db_conn->prepare($query);
        $success = $stmt->execute($data);
        return $success;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function get_avatar($id) {
      $query = 'SELECT avatar, avatar_type FROM users WHERE id=:id';
      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute(array(':id' => $id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }
  }
?>