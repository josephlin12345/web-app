<form class="form" action="" method="POST">
  <label for="email">電子郵件(Email) : 
    <span class="hint"><?php echo $email_err; ?></span>
  </label>
  <br>
  <input
    type="text"
    name="email"
    id="email"
    value="<?php echo $email; ?>"
    maxlength="254"
    size="30"
    required
    autofocus
  >
  <br>
  <label for="password">密碼(Password) : 
    <span class="hint"><?php echo $password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="password"
    id="password"
    minlength="5"
    maxlength="20"
    size="20"
    required
  >
  <br>
  <input type="hidden" id="recaptcha_response" name="recaptcha_response">
  <input
    class="btn submit"
    type="submit"
    name="submit"
    value="登入(Login)"
  >
</form>