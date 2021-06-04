<nav class="navbar">
  <a href="<?php echo $path; ?>homepage.php">
    <img src="<?php echo $path; ?>favicon.png" alt="favicon.png" class="logo">
  </a>
  <div class="selector">
    <select id="theme-selector">
      <?php
        $theme_list = array(
          'light' => '淺色(light)',
          'dark' => '深色(dark)'
        );
        foreach($theme_list as $theme => $theme_name) {
          if($_COOKIE['theme'] != $theme) {
            echo '<option value="' . $theme . '">' . $theme_name . '</option>';
          }
          else {
            echo '<option value="' . $theme . '" selected>' . $theme_name . '</option>';
          }
        }
      ?>
    </select>
  </div>
  <div class="user-option">
    <?php
      if($user) {
        echo '
          <a href="' . $path . 'user/profile.php">
            <img class="btn avatar" src="' . $api_url . '/user/get_avatar.php?id=' . $user['id'] . '">
          </a>
          <a class="btn btn-small" href="' . $path . 'user/posts.php">' . $user['name'] . '</a>
          <a class="btn btn-small" href="' . $path . 'logout.php">登出(Logout)</a>
        ';
      }
      else {
        echo '
          <a class="btn btn-small" href="' . $path . 'login.php">登入(Login)</a>
          <a class="btn btn-small" href="' . $path . 'sign_up.php">註冊(Sign Up)</a>
        ';
      }
    ?>
    <a class="btn btn-small" href="<?php echo $path; ?>about.php">!</a>
  </div>
</nav>