<?php
  // setcookie('user', null, -1, '/');
  session_start();
  session_destroy();
  header('Location: homepage.php');
?>