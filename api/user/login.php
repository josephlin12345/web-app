<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  $data = json_decode(file_get_contents('php://input'), true);
  extract($data);
  require '../config/lang.php';

  if(!(isset($email) && isset($password) && isset($recaptcha_response))) {
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
  require '../models/User.php';

  $database = new Database();
  $db_conn = $database->connect();

  $user_api = new User($db_conn);
  $result = $user_api->get($email);

  if($result) {
    if($result['valid']) {
      if(!password_verify($password, $result['password'])) {
        $error['password_err'] = $text['wrong password'][$lang];
      }
    }
    else {
      $error['email_err'] = $text['account has been deleted'][$lang];
    }
  }
  else {
    $error['email_err'] = $text['did not sign up'][$lang];
  }

  if(count($error) == 0) $response['user'] = $result;
  else $response['error'] = $error;

  echo json_encode($response);
?>