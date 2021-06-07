<?php
  $title = 'sign up';
  $path = '';
  require 'templates/header.php';

  if($_POST['sign_up']) {
    extract($_POST);
    $data = array(
      'name' => $name,
      'email' => $email,
      'password' => $password,
      'confirm_password' => $confirm_password,
      'recaptcha_response' => $recaptcha_response,
      'lang' => $lang
    );

    $ch = curl_init($api_url . '/user/add.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if($response['success']) {
      header('Location: login.php');
      exit;
    }
    else {
      extract($response['error']);
      if($recaptcha_err) echo '<script>alert("' . $recaptcha_err . '")</script>';
    }
  }

  if($user) header('Location: homepage.php');
  require 'templates/recaptcha.php';
?>

<div class="title"><?php echo $text[$title][$lang]; ?></div>

<?php
  require 'templates/form/sign_up.php';
  require 'templates/footer.php';
?>