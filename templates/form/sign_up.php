<form class="form" action="" method="POST">
  <label for="name">名稱(Name) : 
    <span class="hint">* <?php echo $name_err; ?></span>
  </label>
  <br>
  <input
    type="text"
    name="name"
    id="name"
    value="<?php echo $name; ?>"
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
  <label for="confirm_password">確認密碼(Confirm Password) : 
    <span class="hint">* <?php echo $confirm_password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="confirm_password"
    id="confirm_password"
    placeholder="需介於於5 - 20個字 (Must between 5 - 20 characters)"
    minlength="5"
    maxlength="20"
    size="40"
    required
  >
  <br>
  <label for="email">電子郵件(Email) : 
    <span class="hint">* <?php echo $email_err; ?></span>
  </label>
  <br>
  <input
    type="text"
    name="email"
    id="email"
    value="<?php echo $email; ?>"
    placeholder="需少於254個字 (Must less than 254 characters)"
    maxlength="254"
    size="40"
    required
  >
  <br>
  <input type="hidden" id="recaptcha_response" name="recaptcha_response">
  <input
    class="btn btn-big"
    type="submit"
    name="submit"
    value="註冊(Sign Up)"
  >
</form>