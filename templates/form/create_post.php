<form class="form" action="" method="POST">
  <textarea
    name="content"
    cols="40"
    rows="3"
    maxlength="1000"
    placeholder="<?php echo $user['name'] . ', 想說些甚麼 ?' .  PHP_EOL . '(' .  $user['name'] . ', want to post something ?)'; ?>"
    required
    autofocus
  ></textarea>
  <br>
  <input type="hidden" id="recaptcha_response" name="recaptcha_response">
  <input
    class="btn btn-small right"
    type="submit"
    name="post"
    value="發布(Post)"
  >
</form>