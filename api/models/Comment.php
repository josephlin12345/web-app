<?php
  class Comment {
    private $db_conn;

    public function __construct($db_conn) {
      $this->db_conn = $db_conn;
    }

    public function get_total($post_id, $timestamp) {
      $query = 'SELECT count(id)
        FROM comments
        WHERE post_id=:post_id AND valid=true AND modified_at < :timestamp
        ORDER BY modified_at DESC';
      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute(
          array(
            ':post_id' => $post_id,
            ':timestamp' => $timestamp
            )
        );
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count(id)'];
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function get($post_id, $timestamp, $offset, $limit) {
      if($limit > 100) $limit = 100;
      if($offset < 0) $offset = 0;
      $query = 'SELECT comments.id, comments.content, comments.creator_id, comments.modified_at, users.name AS creator_name
        FROM comments
        LEFT JOIN users ON comments.creator_id=users.id
        WHERE post_id=:post_id AND comments.valid=true AND comments.modified_at < :timestamp
        ORDER BY modified_at DESC
        LIMIT ' . $offset . ', ' . $limit;
      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute(
          array(
            ':post_id' => $post_id,
            ':timestamp' => $timestamp
            )
        );
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function get_latest($post_id, $timestamp, $limit) {
      if($limit > 100) $limit = 100;
      $query = 'SELECT comments.id, comments.content, comments.creator_id, comments.modified_at, users.name AS creator_name
        FROM comments
        LEFT JOIN users ON comments.creator_id=users.id
        WHERE post_id=:post_id AND comments.valid=true AND comments.modified_at > :timestamp
        ORDER BY modified_at ASC
        LIMIT ' . $limit;
      try {
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute(
          array(
            ':post_id' => $post_id,
            ':timestamp' => $timestamp
            )
        );
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
      }
      catch(PDOException $e) {
        die('Database Connection Error: ' . $e->getMessage());
      }
    }

    public function create($creator_id, $post_id, $content) {
      $query = 'INSERT INTO comments SET creator_id=:creator_id, post_id=:post_id, content=:content';
      try {
        $stmt = $this->db_conn->prepare($query);
        $success = $stmt->execute(
          array(
            ':creator_id' => $creator_id,
            ':post_id' => $post_id,
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