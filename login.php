<?php
  $title = 'Login';
  $path = '';
  require 'templates/header.php';
  if($user) header('Location: homepage.php');
  require 'templates/recaptcha.php';

  if($_POST['submit']) {
    require 'functions/validation.php';

    extract($_POST);
    if(validate_recaptcha($recaptcha_response)) {
      $user = validate_login($email, $password);
      if($user) {
        $_SESSION['user'] = $user;
        // setcookie('user', json_encode($user), time() + 2592000, '/');
        header('Location: homepage.php');
        exit;
      }
    }
  }
?>

<div class="title"><?php echo $title; ?></div>

<?php
  require 'templates/form/login.php';
  require 'templates/footer.php';
?>