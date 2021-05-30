<div class="form">
  <img class="image" src="<?php echo $path . 'avatars/' . $user['avatar']; ?>" alt="<?php echo $user['avatar']; ?>"></img>
  <p>名稱(Name) : <?php echo $user['name']; ?></p>
  <p>電子郵件(Email) : <?php echo $user['email']; ?></p>
  <p>最後修改時間(Last Modified) : <?php echo $user['modified_at']; ?></p>
  <p>建立時間(Create Time) : <?php echo $user['created_at']; ?></p>
  <br>
  <a class="btn submit" href="<?php echo $path; ?>user/modify_profile.php">修改資料(Modify Profile)</a>
</div>