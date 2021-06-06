<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  $response = array();
  if(!(isset($_GET['timestamp']) && isset($_GET['offset']) && isset($_GET['limit']))) {
    $response['error'] = 'Missing timestamp, offset or limit!';
    echo json_encode($response);
    return;
  }

  require '../config/database.php';
  require '../models/Post.php';

  $database = new Database();
  $db_conn = $database->connect();

  $post_api = new Post($db_conn);
  $result = $post_api->get($_GET['timestamp'], $_GET['offset'], $_GET['limit']);
  $response['data'] = $result;

  echo json_encode($response);
?>