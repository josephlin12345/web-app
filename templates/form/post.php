<form class="post" action="" method="POST">
  <div class="post-info">
    <img class="btn avatar" src="<?php echo $path . 'avatars/' . $post['creator_avatar']; ?>" alt="<?php echo $post['creator_avatar']; ?>">
  </div>
  <div class="post-content">
    <p><?php echo $post['content']; ?></p>
  </div>
</form>