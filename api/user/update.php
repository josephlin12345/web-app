<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  try {
    $data = json_decode(file_get_contents('php://input'), true);
    extract($data);
    if(!(
      isset($name) &&
      isset($password) &&
      isset($avatar) &&
      isset($avatar_type) &&
      isset($new_password) &&
      isset($confirm_new_password) &&
      isset($recaptcha_response) &&
      isset($user) &&
      isset($user['password']) &&
      isset($user['id']) &&
      isset($user['email']))) {
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
  if(!validate_recaptcha($recaptcha_response)) $error['recaptcha_err'] = '未通過驗證(Did not pass recaptcha) !';
  if(!password_verify($password, $user['password'])) $error['password_err'] = '密碼錯誤(Password Error) !';
  if(count($error) != 0) {
    $response['error'] = $error;
    echo json_encode($response);
    return;
  }

  if(!validate_xss($name)) $error['name_err'] = '不合法的名稱(Invalid Name) !';
  if($new_password) {
    if(!validate_xss($new_password)) $error['new_password_err'] = '不合法的密碼(Invalid Password) !';
    if($new_password != $confirm_new_password) $error['confirm_new_password_err'] = '密碼不一致(Different Password) !';
  }

  if(count($error) == 0) {
    require '../config/database.php';
    require '../models/User.php';
  
    $database = new Database();
    $db_conn = $database->connect();

    $user_api = new User($db_conn);
    $success = $user_api->update($user, $avatar, $avatar_type, $name, $new_password);
    $response['success'] = $success;
    $response['user'] = $user_api->get($user['email']);
  }
  else {
    $response['error'] = $error;
  }

  echo json_encode($response);
?>