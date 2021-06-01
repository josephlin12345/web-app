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
    $query = 'INSERT INTO users SET name=:name, password=:password, email=:email';
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
    $query = 'SELECT * FROM users WHERE email=:email AND valid="Y"';
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
    $query = 'UPDATE users SET name=:name, modified_at=DEFAULT';
    $query .= $password ? ', password=:password' : '';
    $query .= $avatar['name'] ? ', avatar=:avatar' : '';
    $query .= ' WHERE id=:id';

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

    try {
      $stmt = $db_conn->prepare($query);
      $success = $stmt->execute($data);
      if(!$success) echo $pdo_err;

      $user = get_user($user['email']);
      // unset($user['password']);
      return $user;
    }
    catch(PDOException) {
      echo $pdo_err;
    }
  }

  // return true if success
  function create_post($content) {
    global $user, $db_conn, $pdo_err;
    $query = 'INSERT INTO posts SET creator=:creator, content=:content';
    try {
      $stmt = $db_conn->prepare($query);
      $success = $stmt->execute(
        array(
          ':creator' => $user['id'],
          ':content' => htmlentities($content)
        )
      );
      if(!$success) echo $pdo_err;
      return $success;
    }
    catch(PDOException)  {
      echo $pdo_err;
    }
  }

  // return posts if success else alert
  function get_posts($offset, $limit) {
    global $db_conn, $pdo_err;
    $query = 'SELECT posts.id, posts.content, posts.modified_at, users.name AS creator_name, users.avatar AS creator_avatar
    FROM posts
    LEFT JOIN users ON posts.creator=users.id
    WHERE posts.valid="Y"
    ORDER BY modified_at DESC
    LIMIT ' . $offset . ', ' . $limit;
    try {
      $stmt = $db_conn->prepare($query);
      $success = $stmt->execute();
      if(!$success) echo $pdo_err;
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $posts;
    }
    catch(PDOException)  {
      echo $pdo_err;
    }
  }

  function get_latest_posts($timestamp) {
    global $db_conn, $pdo_err;
    $query = 'SELECT posts.id, posts.content, posts.modified_at, users.name AS creator_name, users.avatar AS creator_avatar
    FROM posts
    LEFT JOIN users ON posts.creator=users.id
    WHERE posts.valid="Y" AND posts.modified_at > "' . $timestamp . '"
    ORDER BY modified_at ASC';
    try {
      $stmt = $db_conn->prepare($query);
      $success = $stmt->execute();
      if(!$success) echo $pdo_err;
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $posts;
    }
    catch(PDOException)  {
      echo $pdo_err;
    }
  }
?>