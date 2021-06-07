<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  $data = json_decode(file_get_contents('php://input'), true);
  extract($data);
  require '../config/lang.php';

  if(!(isset($name) && isset($email) && isset($password) && isset($confirm_password) && isset($recaptcha_response))) {
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

  if(!validate_xss($name)) $error['name_err'] = $text['invalid name'][$lang];
  if(!validate_xss($password)) $error['password_err'] = $text['invalid password'][$lang];
  if($password != $confirm_password) $error['confirm_password_err'] = $text['different password'][$lang];
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error['email_err'] = $text['invalid email'][$lang];
  else {
    require '../config/database.php';
    require '../models/User.php';
  
    $database = new Database();
    $db_conn = $database->connect();

    $user_api = new User($db_conn);
    if($user_api->get($email)) $error['email_err'] = $text['email has been signed up'][$lang];
  }

  if(count($error) == 0) {
    $success = $user_api->add($email, $name, $password);
    $response['success'] = $success;
  }
  else {
    $response['error'] = $error;
  }

  echo json_encode($response);
?>