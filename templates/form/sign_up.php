<form class="form" action="" method="POST">
  <label for="name"><?php echo $text['name'][$lang]; ?> : 
    <span class="hint">* <?php echo $name_err; ?></span>
  </label>
  <br>
  <input
    type="text"
    name="name"
    id="name"
    value="<?php echo $name; ?>"
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
  <label for="confirm_password"><?php echo $text['confirm'][$lang] . ' ' . $text['password'][$lang]; ?> : 
    <span class="hint">* <?php echo $confirm_password_err; ?></span>
  </label>
  <br>
  <input
    type="password"
    name="confirm_password"
    id="confirm_password"
    placeholder="<?php echo $text['must between'][$lang] . ' 5 - 20 ' . $text['characters'][$lang]; ?>"
    minlength="5"
    maxlength="20"
    size="40"
    required
  >
  <br>
  <label for="email"><?php echo $text['email'][$lang]; ?> : 
    <span class="hint">* <?php echo $email_err; ?></span>
  </label>
  <br>
  <input
    type="text"
    name="email"
    id="email"
    value="<?php echo $email; ?>"
    placeholder="<?php echo $text['must less than'][$lang] . ' 254 ' . $text['characters'][$lang]; ?>"
    maxlength="254"
    size="40"
    required
  >
  <br>
  <input type="hidden" id="recaptcha_response" name="recaptcha_response">
  <input
    class="btn btn-big"
    type="submit"
    name="sign_up"
    value="<?php echo $text['sign up'][$lang]; ?>"
  >
</form>