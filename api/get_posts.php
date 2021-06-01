<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');
  header('Content-Type: application/json');

  if(isset($_GET['offset']) && isset($_GET['limit'])) {
    require '../functions/database.php';
  
    $database = new Database();
    $db_conn = $database->connect();
  
    $posts = get_posts($_GET['offset'], $_GET['limit']);
    echo json_encode($posts);
  }
  else {
    echo json_encode(array('message' => 'Miss offset or limit parameter!'));
  }
?>