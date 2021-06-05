<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  try {
    $data = json_decode(file_get_contents('php://input'), true);
    extract($data);
    if(!(isset($user) && isset($user['id']) && isset($user['email']) && isset($user['password']) && isset($content) && isset($recaptcha_response))) {
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
  require '../models/User.php';

  $database = new Database();
  $db_conn = $database->connect();

  $user_api = new User($db_conn);
  $result = $user_api->get($user['email']);

  if(!($result && $result['valid'] && $user['password'] == $result['password'])) {
    $error['user_err'] = '不合法的使用者(Invalid user) !';
    $response['error'] = $error;
    echo json_encode($response);
    return;
  }

  require '../models/Post.php';

  $post_api = new Post($db_conn);
  $success = $post_api->create($user, $content);
  $response['success'] = $success;

  echo json_encode($response);
?>