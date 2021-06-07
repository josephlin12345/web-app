<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: image/*');
  header('Access-Control-Allow-Methods: GET');

  if(!(isset($_GET['id']))) {
    header('Content-Type: application/json');
    require '../config/lang.php';
    $response = array('error' => $text['missing data'][$lang]);
    echo json_encode($response);
    return;
  }

  require '../config/database.php';
  require '../models/User.php';

  $database = new Database();
  $db_conn = $database->connect();

  $user_api = new User($db_conn);
  $result = $user_api->get_avatar($_GET['id']);
  if($result && $result['avatar']) {
    header('Content-Disposition: filename=' . $_GET['id'] . '.' . $result['avatar_type']);
    echo $result['avatar'];
  }
  else {
    $default = 'default.png';
    header('Content-Disposition: filename=' . $default);
    $fp = fopen($default, 'r');
    $file = fread($fp, filesize($default));
    fclose($fp);
    echo $file;
  }
?>