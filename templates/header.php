<?php
  session_start();
  $user = $_SESSION['user'];
  // change from 2 to 1
  if(!$user && count(explode('/', $_SERVER['PHP_SELF'], -1)) != 2) {
    header('Location: ' . $path . 'login.php');
    exit;
  }
  require $path . 'templates/lang.php';
  $api_url = 'http://i4010.isrcttu.net:9651/api';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?php echo $path; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo $path; ?>css/selector.css">
  <link rel="stylesheet" href="<?php echo $path; ?>css/background.css">
  <link rel="stylesheet" href="<?php echo $path; ?>css/content.css">
  <link rel="icon" href="<?php echo $path; ?>favicon.png">

  <script src="<?php echo $path; ?>js/lang.js" defer></script>
  <script src="<?php echo $path; ?>js/selector.js" defer></script>

  <title><?php echo $text[$title][$lang]; ?></title>
</head>
<body class="<?php echo $_COOKIE['theme']; ?>">
  <?php require $path . 'templates/navbar.php'; ?>