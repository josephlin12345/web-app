<?php
  $title = 'About';
  $path = '';
  require $path . 'templates/header.php';
?>

<div class="title"><?php echo $title; ?></div>

<?php
  require $path . 'templates/document/about.php';
  require $path . 'templates/footer.php';
?>