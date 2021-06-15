<?php
  $title = 'about';
  $path = '';
  require 'templates/header.php';
?>

<div class="title"><?php echo $text[$title][$lang]; ?></div>
<div class="form">
  <p><?php echo $text['owner'][$lang]; ?> : I3B24 林浚喆</p>
  <p><?php echo $text['collaborator'][$lang]; ?> : I3B59 許家豪、I3B09 沈大中</p>
</div>

<?php require 'templates/footer.php'; ?>