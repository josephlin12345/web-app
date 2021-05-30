<?php
  $title = 'Sign Up';
  $path = '';
  require 'templates/header.php';
  if($user) header('Location: homepage.php');
  require 'templates/recaptcha.php';

  if($_POST['submit']) {
    require 'functions/validation.php';

    extract($_POST);
    if(validate_recaptcha($recaptcha_response)) {
      if(validate_sign_up($name, $password, $confirm_password, $email)) {
        if(add_user($name, $password, $email)) {
          header('Location: login.php');
          exit;
        }
      }
    }
  }
?>

<div class="title"><?php echo $title; ?></div>

<?php
  require 'templates/form/sign_up.php';
  require 'templates/footer.php';
?>