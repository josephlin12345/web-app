<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  try {
    $data = json_decode(file_get_contents('php://input'), true);
    extract($data);
    if(!(isset($name) && isset($email) && isset($password) && isset($confirm_password) && isset($recaptcha_response))) {
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

  if(!validate_xss($name)) $error['name_err'] = '不合法的名稱(Invalid Name) !';
  if(!validate_xss($password)) $error['password_err'] = '不合法的密碼(Invalid Password) !';
  if($password != $confirm_password) $error['confirm_password_err'] = '密碼不一致(Different Password) !';
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error['email_err'] = '不合法的電子郵件(Invalid Email) !';
  else {
    require '../config/database.php';
    require '../models/User.php';
  
    $database = new Database();
    $db_conn = $database->connect();

    $user_api = new User($db_conn);
    if($user_api->get($email)) $error['email_err'] = '電子郵件已註冊過(Email already signed up) !';
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