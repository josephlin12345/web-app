<?php
  $title = 'Profile';
  $path = '../';
  require $path . 'templates/header.php';
?>

<div class="title"><?php echo $title; ?></div>
<div class="form">
  <img class="image" src="<?php echo $api_url . '/user/get_avatar.php?id=' . $user['id']; ?>"></img>
  <p>名稱(Name) : <?php echo $user['name']; ?></p>
  <p>電子郵件(Email) : <?php echo $user['email']; ?></p>
  <p>最後修改時間(Last Modified) : <?php echo $user['modified_at'] . ' UTC+0'; ?></p>
  <p>建立時間(Create Time) : <?php echo $user['created_at'] . ' UTC+0'; ?></p>
  <br>
  <a class="btn btn-big" href="<?php echo $path; ?>user/modify_profile.php">修改資料(Modify Profile)</a>
</div>

<?php require $path . 'templates/footer.php'; ?>