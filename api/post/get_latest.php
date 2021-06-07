<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  $response = array();
  require '../config/lang.php';

  if(!(isset($_GET['timestamp']) && isset($_GET['limit']))) {
    $response['error'] = $text['missing data'][$lang];
    echo json_encode($response);
    return;
  }

  require '../config/database.php';
  require '../models/Post.php';

  $database = new Database();
  $db_conn = $database->connect();

  $post_api = new Post($db_conn);
  $result = $post_api->get_latest($_GET['timestamp'], $_GET['limit']);
  $response['data'] = $result;

  echo json_encode($response);
?>