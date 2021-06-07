<?php
  $title = 'user posts';
  $path = '../';
  require $path . 'templates/header.php';
  require $path . 'templates/recaptcha.php';

  if($_GET['id']) $load_user_id = $_GET['id'];
  else $load_user_id = $user['id'];
  $load_type = 'user';
  require $path . 'templates/posts.php';

  require $path . 'templates/footer.php';
?>