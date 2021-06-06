<div class="form">
  <textarea
    class="create-post"
    maxlength="1000"
    placeholder="<?php echo $user['name'] . ', ' . $text['want to post something'][$lang]; ?> ?"
    autofocus
  ></textarea>
  <br>
  <button class="btn btn-small right" onclick="create_post(<?php echo $user['id']; ?>)"><?php echo $text['post'][$lang]; ?></button>
</div>