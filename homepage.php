<?php
  $title = 'Homepage';
  $path = '';
  require 'templates/header.php';
  require 'templates/recaptcha.php';

  if($_POST['post']) {
    require 'functions/validation.php';

    extract($_POST);
    if(validate_recaptcha($recaptcha_response)) {
      if(create_post($content)) {
        header('Location: homepage.php');
        exit;
      }
    }
  }

  if($user) require 'templates/form/create_post.php';
  require 'templates/posts.php';
  require 'templates/footer.php';
?>