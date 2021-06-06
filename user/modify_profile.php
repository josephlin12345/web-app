<?php
  $title = 'modify profile';
  $path = '../';
  require $path . 'templates/header.php';

  if($_POST['confirm']) {
    extract($_POST);
    $data = array(
      'user' => $user,
      'name' => $name,
      'avatar' => '',
      'avatar_type' => '',
      'password' => $password,
      'new_password' => $new_password,
      'confirm_new_password' => $confirm_new_password,
      'recaptcha_response' => $recaptcha_response      
    );
    if(!$_FILES['avatar']['error']) {
      extract($_FILES);
      $fp = fopen($avatar['tmp_name'], 'r');
      $file = fread($fp, filesize($avatar['tmp_name']));
      fclose($fp);
      $data['avatar'] = base64_encode($file);
      $data['avatar_type'] = pathinfo($avatar['name'], PATHINFO_EXTENSION);
    }

    $ch = curl_init($api_url . '/user/update.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if($response['success']) {
      $_SESSION['user'] = $response['user'];
      header('Location: ' . $path . 'user/profile.php');
      exit;
    }
    else {
      extract($response['error']);
      if($recaptcha_err) echo '<script>alert("' . $recaptcha_err . '")</script>';
    }
  }

  require $path . 'templates/recaptcha.php';
?>

<div class="title"><?php echo $text[$title][$lang]; ?></div>

<?php
  require $path . 'templates/form/modify_profile.php';
  require $path . 'templates/footer.php';
?>