<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  try {
    $data = json_decode(file_get_contents('php://input'), true);
    extract($data);
    if(!(isset($creator_id) && isset($post_id) && isset($content) && isset($recaptcha_response))) {
      throw new Exception();
    }
  }
  catch(Exception $e) {
    $response['error'] = 'Missing post data!';
    echo json_encode($response);
    return;
  }

  require '../config/validation.php';

  $error = array();
  if(!validate_recaptcha($recaptcha_response)) {
    $error['recaptcha_err'] = '未通過驗證(Did not pass recaptcha) !';
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