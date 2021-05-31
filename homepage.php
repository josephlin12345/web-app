<?php
  $title = 'Homepage';
  $path = '';
  require 'templates/header.php';

  if($user) require 'templates/form/create_post.php';

  require 'templates/footer.php';
 ?>
