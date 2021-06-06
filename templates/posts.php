<script src="<?php echo $path; ?>js/posts.js" defer></script>
<script src="<?php echo $path; ?>js/comments.js" defer></script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    set_load_options('<?php echo $user_id; ?>', '<?php echo $load_type; ?>');
  });
</script>

<input type="hidden" id="recaptcha_response">
<div id="posts" class="container">
  <template id="post">
    <div class="post" id="">
      <div class="content-header">
        <a href=""><img class="btn avatar" src=""></a>
        <div class="content-info">
          <span class="creator-name"></span>
          <span class="modified-at"></span>
        </div>
      </div>
      <p class="content"></p>
      <button class="btn right" onclick="" name="show_more"><?php echo $text['show more'][$lang]; ?></button>
      <button class="btn" onclick="" name="comments"><?php echo $text['show comments'][$lang]; ?></button>
      <div class="comments container hidden">
        <?php if($user) { ?>
        <div class="form">
          <textarea class="create-comment" id="" maxlength="1000"></textarea>
          <button class="btn btn-small right" onclick="" name="create_comment"><?php echo $text['comment'][$lang]; ?></button>
        </div>
        <?php }; ?>
        <button class="btn hidden" onclick="" name="load_more_comments"><?php echo $text['load more comments'][$lang]; ?></button>
      </div>
    </div>
  </template>
  <template id="comment">
    <div class="comment" id="">
      <div class="content-header">
        <a href=""><img class="btn avatar" src=""></a>
        <div class="content-info">
          <span class="creator-name"></span>
          <span class="modified-at"></span>
        </div>
      </div>
      <p class="content"></p>
    </div>
  </template>
</div>