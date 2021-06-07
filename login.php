<?php
  $title = 'login';
  $path = '';
  require 'templates/header.php';

  if($_POST['login']) {
    extract($_POST);
    $data = array(
      'email' => $email,
      'password' => $password,
      'recaptcha_response' => $recaptcha_response,
      'lang' => $lang
    );

    $ch = curl_init($api_url . '/user/login.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if($response['user']) {
      $_SESSION['user'] = $response['user'];
      header('Location: homepage.php');
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
  require 'templates/form/login.php';
  require 'templates/footer.php';
?>