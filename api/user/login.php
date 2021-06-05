<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  $response = array();
  try {
    $data = json_decode(file_get_contents('php://input'), true);
    extract($data);
    if(!(isset($email) && isset($password) && isset($recaptcha_response))) {
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
  $result = $user_api->get($email);

  if($result) {
    if($result['valid']) {
      if(!password_verify($password, $result['password'])) {
        $error['password_err'] = '密碼錯誤(Password Error) !';
      }
    }
    else {
      $error['email_err'] = '帳號已被刪除(Account has been deleted) !';
    }
  }
  else {
    $error['email_err'] = '尚未註冊的電子郵件(Did not Sign Up) !';
  }

  if(count($error) == 0) $response['user'] = $result;
  else $response['error'] = $error;

  echo json_encode($response);
?>