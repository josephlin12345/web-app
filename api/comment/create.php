<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  $data = json_decode(file_get_contents('php://input'), true);
  extract($data);
  require '../config/lang.php';

  if(!(isset($creator_id) && isset($post_id) && isset($content) && isset($recaptcha_response))) {
    $response['error'] = $text['missing data'][$lang];
    echo json_encode($response);
    return;
  }

  require '../config/validation.php';

  $error = array();
  if(!validate_recaptcha($recaptcha_response)) {
    $error['recaptcha_err'] = $text['did not pass recaptcha'][$lang];
    $response['error'] = $error;
    echo json_encode($response);
    return;
  }

  require '../config/database.php';
  require '../models/Comment.php';

  $database = new Database();
  $db_conn = $database->connect();

  $comment_api = new Comment($db_conn);
  $success = $comment_api->create($creator_id, $post_id, $content);
  $response['success'] = $success;

  echo json_encode($response);
?>