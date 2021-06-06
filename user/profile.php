<?php
  $title = 'profile';
  $path = '../';
  require $path . 'templates/header.php';
?>

<div class="title"><?php echo $text[$title][$lang]; ?></div>
<div class="form">
  <img class="image" src="<?php echo $api_url . '/user/get_avatar.php?id=' . $user['id']; ?>"></img>
  <p><?php echo $text['name'][$lang] . ' : ' . $user['name']; ?></p>
  <p><?php echo $text['email'][$lang] . ' : ' . $user['email']; ?></p>
  <p><?php echo $text['last modified at'][$lang] . ' : ' . $user['modified_at'] . ' UTC+0'; ?></p>
  <p><?php echo $text['create time'][$lang] . ' : ' . $user['created_at'] . ' UTC+0'; ?></p>
  <br>
  <a class="btn btn-big" href="<?php echo $path; ?>user/modify_profile.php"><?php echo $text['modify profile'][$lang]; ?></a>
</div>

<?php require $path . 'templates/footer.php'; ?>