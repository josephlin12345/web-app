<?php
  class Database {
    // db parameters
    private $host = 'localhost';
    private $dbname = 'project';
    private $username = 'root';
    private $password = '';

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

  $database = new Database();
  $db_conn = $database->connect();
  $pdo_err = '
    <script>
      if(!alert("資料庫連線錯誤(Database Connection Error) !"))
        window.history.back();
    </script>
  ';

  // return true if success
  function add_user($name, $password, $email) {
    global $db_conn, $pdo_err;
    $query = '
      INSERT INTO
        users
      SET
        email=:email,
        name=:name,
        password=:password
    ';
    try {
      $stmt = $db_conn->prepare($query);
      $success = $stmt->execute(
        array(
          ':email' => $email,
          ':name' => $name,
          ':password' => password_hash($password, PASSWORD_DEFAULT)
        )
      );
      if(!$success) echo $pdo_err;
      return $success;
    }
    catch(PDOException) {
      echo $pdo_err;
    }
  }

  // return user if found else false
  function get_user($email) {
    global $db_conn, $pdo_err;
    $query = '
      SELECT
        *
      FROM
        users
      WHERE
        email=:email
    ';
    try {
      $stmt = $db_conn->prepare($query);
      $success = $stmt->execute(array(':email' => $email));
      if(!$success) echo $pdo_err;
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      return $user;
    }
    catch(PDOException) {
      echo $pdo_err;
    }
  }

  // return user if success else alert
  function update_user($avatar, $name, $password) {
    global $path, $user, $db_conn, $pdo_err;

    $data = array(':name' => $name, ':id' => $user['id']);
    if($password) $data[':password'] = password_hash($password, PASSWORD_DEFAULT);
    if($avatar['name']) {
      $folder = $path . 'avatars/';
      if($user['avatar'] != 'default.png') {
        unlink($folder . $user['avatar']);
      }
      $filename = $user['id'] . '.' . pathinfo($avatar['name'], PATHINFO_EXTENSION);
      $data[':avatar'] = $filename;
      move_uploaded_file($avatar['tmp_name'], $folder . $filename);
    }

    $query = '
      UPDATE
        users
      SET
        name=:name,
    ';
    $query .= $password ? 'password=:password,' : '';
    $query .= $avatar['name'] ? 'avatar=:avatar,' : '';
    $query .= '
        modified_at=DEFAULT
      WHERE
        id=:id
    ';
    try {
      $stmt = $db_conn->prepare($query);
      $success = $stmt->execute($data);
      if(!$success) echo $pdo_err;

      $user = get_user($user['email']);
      unset($user['password']);
      return $user;
    }
    catch(PDOException) {
      echo $pdo_err;
    }
  }
?>