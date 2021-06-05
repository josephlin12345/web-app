<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  $response = array();
  if(!(isset($_GET['user_id']) && isset($_GET['offset']) && isset($_GET['limit']))) {
    $response['error'] = 'Missing user_id, offset or limit!';
    echo json_encode($response);
    return;
  }

  require '../config/database.php';
  require '../models/Post.php';

  $database = new Database();
  $db_conn = $database->connect();

  $post_api = new Post($db_conn);
  $result = $post_api->get_user($_GET['user_id'], $_GET['offset'], $_GET['limit']);
  $response['data'] = $result;

  echo json_encode($response);
?>