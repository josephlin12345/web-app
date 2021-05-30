<script src="<?php echo $path; ?>js/image_preview.js" defer></script>
<form class="form" action="" method="POST" enctype="multipart/form-data">
  <label for="image">頭像(Avatar) : 
    <span><?php echo $avatar_err; ?></span>
  </label>
  <br>
  <img class="image" id="image_preview" src="<?php echo $path . 'avatars/' . $user['avatar']; ?>" alt="<?php echo $user['avatar']; ?>"></img>
  <br>
  <input
    type="file"
    name="avatar"
    id="image"
    accept=".jpg, .jpeg, .png, .gif"
  >
  <br>
  <label for="name">名稱(Name) : 
    <span class="hint">* <?php echo $name_err; ?></span>
  </label>
  <br>
  <input
    type="text"
    name="name"
    id="name"
    value="<?php echo $user['name']; ?>"
    placeholder="需介於於3 - 20個字 (Must between 3 - 20 characters)"
    minlength="3"
    maxlength="20"
    size="40"
    required
    autofocus
  >
  <br>
  <label for="password">密碼(Password) : 
    <span class="hint">* <?php echo $password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="password"
    id="password"
    placeholder="需介於於5 - 20個字 (Must between 5 - 20 characters)"
    minlength="5"
    maxlength="20"
    size="40"
    required
  >
  <br>
  <label for="new_password">新密碼(New Password) : 
    <span class="hint"><?php echo $new_password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="new_password"
    id="new_password"
    placeholder="需介於於5 - 20個字 (Must between 5 - 20 characters)"
    minlength="5"
    maxlength="20"
    size="40"
  >
  <br>
  <label for="confirm_new_password">確認新密碼(Confirm New Password) : 
    <span class="hint"><?php echo $confirm_new_password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="confirm_new_password"
    id="confirm_new_password"
    placeholder="需介於於5 - 20個字 (Must between 5 - 20 characters)"
    minlength="5"
    maxlength="20"
    size="40"
  >
  <br>
  <input type="hidden" id="recaptcha_response" name="recaptcha_response">
  <input
    class="btn submit"
    type="submit"
    name="submit"
    value="提交(Submit)"
  >
</form>