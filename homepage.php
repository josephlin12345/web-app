<?php
  $title = 'Homepage';
  $path = '';
  require 'templates/header.php';

  if($_POST['post']) {
    extract($_POST);
    $data = array(
      'user' => $user,
      'content' => $content,
      'recaptcha_response' => $recaptcha_response
    );

    $ch = curl_init($api_url . '/post/create.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if(!$response['success']) {
      extract($response['error']);
      if($recaptcha_err) echo '<script>alert("' . $recaptcha_err . '")</script>';
    }
  }

  if($user) {
    require 'templates/recaptcha.php';
    require 'templates/form/create_post.php';
  }
  require 'templates/posts.php';
  require 'templates/footer.php';
?>