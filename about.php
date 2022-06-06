<?php
  $title = 'about';
  $path = '';
  require 'templates/header.php';
?>

<div class="title"><?php echo $text[$title][$lang]; ?></div>
<div class="form">
  <p><?php echo $text['owner'][$lang]; ?> : I3B24 林浚喆</p>
</div>

<?php require 'templates/footer.php'; ?>
