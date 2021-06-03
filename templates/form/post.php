<template id="post">
  <form class="post" id="" action="" method="POST">
    <div class="post-header">
      <img class="btn avatar" src="" alt="">
      <div class="post-info">
        <span class="creator-name"></span>
        <span class="modified-at"></span>
      </div>
    </div>
    <p class="post-content"></p>
    <button class="btn right" type="button" onclick="">show more</button>
    <?php if($user) echo '<input class="btn" type="submit" name="comment" value="留言(Comment)">'; ?>
  </form>
</template>