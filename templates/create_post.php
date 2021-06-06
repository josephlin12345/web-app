<div class="form">
  <textarea
    class="create-post"
    maxlength="1000"
    placeholder="<?php echo $user['name'] . ', 想說些甚麼 ?' .  PHP_EOL . '(' .  $user['name'] . ', want to post something ?)'; ?>"
    autofocus
  ></textarea>
  <br>
  <button class="btn btn-small right" onclick="create_post(<?php echo $user['id']; ?>)">發布(Post)</button>
</div>