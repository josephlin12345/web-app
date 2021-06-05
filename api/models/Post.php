<?php
  class Post {
    private $db_conn;

    public function __construct($db_conn) {
      $this->db_conn = $db_conn;
    }

    public function get($offset, $limit) {
      if($limit > 100) $limit = 100;
      if($offset < 0) $offset = 0;

      $query = 'SELECT posts.id, posts.content, posts.modified_at, users.name AS creator_name, users.id AS creator_id
        FROM posts
        LEFT JOIN users ON posts.creator=users.id
        WHERE posts.valid=true
        ORDER BY modified_at DESC
        LIMIT ' . $offset . ', ' . $limit;

      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function get_latest($timestamp) {
      $query = 'SELECT posts.id, posts.content, posts.modified_at, users.name AS creator_name, users.id AS creator_id
        FROM posts
        LEFT JOIN users ON posts.creator=users.id
        WHERE posts.valid=true AND posts.modified_at > :timestamp
        ORDER BY modified_at ASC';
      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute(array(':timestamp' => $timestamp));
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function get_user($user_id, $offset, $limit) {
      if($limit > 100) $limit = 100;
      if($offset < 0) $offset = 0;

      $query = 'SELECT posts.id, posts.content, posts.modified_at, users.name AS creator_name, users.id AS creator_id
        FROM users
        LEFT JOIN posts ON posts.creator=users.id
        WHERE users.id=:user_id AND posts.valid=true
        ORDER BY modified_at DESC
        LIMIT ' . $offset . ', ' . $limit;

      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute(array(':user_id' => $user_id));
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function create($user, $content) {
      $query = 'INSERT INTO posts SET creator=:creator, content=:content';
      try {
        $stmt = $this->db_conn->prepare($query);
        $success = $stmt->execute(
          array(
            ':creator' => $user['id'],
            ':content' => htmlentities($content)
          )
        );
        return $success;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }
  }
?>