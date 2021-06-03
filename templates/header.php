<?php
  session_start();
  extract($_SESSION);
  if(!$user && count(explode('/', $_SERVER['PHP_SELF'], -1)) != 1) {
    header('Location: ' . $path . 'login.php');
    exit;
  }
  $api_url = 'http://i4010.isrcttu.net:9651/api';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?php echo $path; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo $path; ?>css/selector.css">
  <link rel="stylesheet" href="<?php echo $path; ?>css/background.css">
  <link rel="stylesheet" href="<?php echo $path; ?>css/post.css">
  <link rel="icon" href="<?php echo $path; ?>favicon.png">

  <script src="<?php echo $path; ?>js/theme_selector.js" defer></script>

  <title><?php echo $title; ?></title>
</head>
<body class="<?php echo $_COOKIE['theme']; ?>">
  <?php require $path . 'templates/navbar.php'; ?>