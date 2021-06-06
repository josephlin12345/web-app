<?php
  $title = 'homepage';
  $path = '';
  require 'templates/header.php';

  if($user) {
    require 'templates/recaptcha.php';
    require 'templates/create_post.php';
    $user_id = $user['id'];
  }
  else $user_id = null;
  $load_type = 'all';
  require 'templates/posts.php';

  require 'templates/footer.php';
?>