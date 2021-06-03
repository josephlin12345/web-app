<?php
  $title = 'Profile';
  $path = '../';
  require $path . 'templates/header.php';
?>

<div class="title"><?php echo $title; ?></div>

<?php
  require $path . 'templates/document/profile.php';
  require $path . 'templates/footer.php';
?>