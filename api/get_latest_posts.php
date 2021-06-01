<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');
  header('Content-Type: application/json');

  if(isset($_GET['timestamp'])) {
    require '../functions/database.php';
  
    $database = new Database();
    $db_conn = $database->connect();
  
    $posts = get_latest_posts($_GET['timestamp']);
    echo json_encode($posts);
  }
  else {
    echo json_encode(array('message' => 'Miss offset or limit parameter!'));
  }
?>