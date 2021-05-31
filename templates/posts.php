<?php
  $limit = 3;
  $offset = 0;
  $posts = get_posts(0, 3);
?>

<div class="posts">
  <?php
    foreach($posts as $post) {
      require 'templates/form/post.php';
    }
  ?>
</div>