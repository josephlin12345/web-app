<?php
  $title = 'Modify Profile';
  $path = '../';
  require $path . 'templates/header.php';
  require $path . 'templates/recaptcha.php';

  if($_POST['submit']) {
    require $path . 'functions/validation.php';

    extract($_POST);
    if(validate_recaptcha($recaptcha_response)) {
      if(validate_user($user['email'], $password)) {
        if(validate_modify_profile($_FILES['avatar'], $name, $new_password, $confirm_new_password)) {
          // bug
          $user = update_user($_FILES['avatar'], $name, $new_password);
          if($user) {
            $_SESSION['user'] = $user;
            // setcookie('user', json_encode($user), time() + 2592000, '/');
            header('Location: ' . $path . 'user/profile.php');
            exit;
          }
        }
      }
    }
  }
?>

<div class="title"><?php echo $title; ?></div>

<?php
  require $path . 'templates/form/modify_profile.php';
  require $path . 'templates/footer.php';
?>