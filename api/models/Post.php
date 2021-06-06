<?php
  class Post {
    private $db_conn;

    public function __construct($db_conn) {
      $this->db_conn = $db_conn;
    }

    public function get($timestamp, $offset, $limit) {
      if($limit > 100) $limit = 100;
      if($offset < 0) $offset = 0;
      $query = 'SELECT posts.id, posts.creator_id, posts.content, posts.modified_at, users.name AS creator_name
        FROM posts
        LEFT JOIN users ON posts.creator_id=users.id
        WHERE posts.valid=true AND posts.modified_at < :timestamp
        ORDER BY modified_at DESC
        LIMIT ' . $offset . ', ' . $limit;
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

    public function get_latest($timestamp, $limit) {
      if($limit > 100) $limit = 100;
      $query = 'SELECT posts.id, posts.creator_id, posts.content, posts.modified_at, users.name AS creator_name
        FROM posts
        LEFT JOIN users ON posts.creator_id=users.id
        WHERE posts.valid=true AND posts.modified_at > :timestamp
        ORDER BY modified_at ASC
        LIMIT ' . $limit;
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
      $query = 'SELECT posts.id, posts.creator_id, posts.content, posts.modified_at, users.name AS creator_name
        FROM users
        LEFT JOIN posts ON posts.creator_id=users.id
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

    public function create($creator_id, $content) {
      $query = 'INSERT INTO posts SET creator_id=:creator_id, content=:content';
      try {
        $stmt = $this->db_conn->prepare($query);
        $success = $stmt->execute(
          array(
            ':creator_id' => $creator_id,
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