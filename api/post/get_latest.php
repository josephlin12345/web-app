<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  $response = array();
  if(!isset($_GET['timestamp'])) {
    $response['error'] = 'Missing timestamp!';
    echo json_encode($response);
    return;
  }

  require '../config/database.php';
  require '../models/Post.php';

  $database = new Database();
  $db_conn = $database->connect();

  $post_api = new Post($db_conn);
  $result = $post_api->get_latest($_GET['timestamp']);
  $response['data'] = $result;

  echo json_encode($response);
?>