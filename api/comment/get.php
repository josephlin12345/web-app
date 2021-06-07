<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  $response = array();
  require '../config/lang.php';

  if(!(isset($_GET['post_id']) && isset($_GET['timestamp']) && isset($_GET['offset']) && isset($_GET['limit']))) {
    $response['error'] = $text['missing data'][$lang];
    echo json_encode($response);
    return;
  }

  require '../config/database.php';
  require '../models/Comment.php';

  $database = new Database();
  $db_conn = $database->connect();

  $comment_api = new Comment($db_conn);
  $result = $comment_api->get($_GET['post_id'], $_GET['timestamp'], $_GET['offset'], $_GET['limit']);
  $response['data'] = $result;

  echo json_encode($response);
?>