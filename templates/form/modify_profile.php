<script src="<?php echo $path; ?>js/image_handler.js" defer></script>
<form class="form" action="" method="POST" enctype="multipart/form-data">
  <label for="image"><?php echo $text['avatar'][$lang]; ?> : </label>
  <br>
  <img class="image" id="image_preview" src="<?php echo $api_url . '/user/get_avatar.php?id=' . $user['id']; ?>"></img>
  <br>
  <input
    type="file"
    name="avatar"
    id="image"
    accept=".jpg, .jpeg, .png, .gif"
  >
  <br>
  <label for="name"><?php echo $text['name'][$lang]; ?> : 
    <span class="hint">* <?php echo $name_err; ?></span>
  </label>
  <br>
  <input
    type="text"
    name="name"
    id="name"
    value="<?php echo $user['name']; ?>"
    placeholder="<?php echo $text['must between'][$lang] . ' 3 - 20 ' . $text['characters'][$lang]; ?>"
    minlength="3"
    maxlength="20"
    size="40"
    required
    autofocus
  >
  <br>
  <label for="password"><?php echo $text['password'][$lang]; ?> : 
    <span class="hint">* <?php echo $password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="password"
    id="password"
    placeholder="<?php echo $text['must between'][$lang] . ' 5 - 20 ' . $text['characters'][$lang]; ?>"
    minlength="5"
    maxlength="20"
    size="40"
    required
  >
  <br>
  <label for="new_password"><?php echo $text['new'][$lang] . ' ' . $text['password'][$lang]; ?> : 
    <span class="hint"><?php echo $new_password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="new_password"
    id="new_password"
    placeholder="<?php echo $text['must between'][$lang] . ' 5 - 20 ' . $text['characters'][$lang]; ?>"
    minlength="5"
    maxlength="20"
    size="40"
  >
  <br>
  <label for="confirm_new_password"><?php echo $text['confirm'][$lang] . ' ' . $text['new'][$lang] . ' ' . $text['password'][$lang]; ?> : 
    <span class="hint"><?php echo $confirm_new_password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="confirm_new_password"
    id="confirm_new_password"
    placeholder="<?php echo $text['must between'][$lang] . ' 5 - 20 ' . $text['characters'][$lang]; ?>"
    minlength="5"
    maxlength="20"
    size="40"
  >
  <br>
  <input type="hidden" id="recaptcha_response" name="recaptcha_response">
  <input
    class="btn btn-big"
    type="submit"
    name="confirm"
    value="<?php echo $text['confirm'][$lang]; ?>"
  >
</form>