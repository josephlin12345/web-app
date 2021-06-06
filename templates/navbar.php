<nav class="navbar">
  <a href="<?php echo $path; ?>homepage.php">
    <img src="<?php echo $path; ?>favicon.png" alt="favicon.png" class="logo">
  </a>
  <div class="selector">
    <select id="theme-selector">
      <?php
        $theme_list = array(
          'light' => $text['light'][$lang],
          'dark' => $text['dark'][$lang]
        );
        foreach($theme_list as $theme => $theme_name) {
          if($_COOKIE['theme'] != $theme) echo '<option value="' . $theme . '">' . $theme_name . '</option>';
          else echo '<option value="' . $theme . '" selected>' . $theme_name . '</option>';
        }
      ?>
    </select>
  </div>
  <div class="selector">
    <select id="lang-selector">
      <?php
        $lang_list = array(
          'en' => 'english',
          'zh-TW' => '中文(繁體)'
        );
        foreach($lang_list as $lang_type => $lang_name) {
          if($_COOKIE['lang'] != $lang_type) echo '<option value="' . $lang_type . '">' . $lang_name . '</option>';
          else echo '<option value="' . $lang_type . '" selected>' . $lang_name . '</option>';
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
          <a class="btn btn-small" href="' . $path . 'logout.php">' . $text['logout'][$lang] . '</a>
        ';
      }
      else {
        echo '
          <a class="btn btn-small" href="' . $path . 'login.php">' . $text['login'][$lang] . '</a>
          <a class="btn btn-small" href="' . $path . 'sign_up.php">' . $text['sign up'][$lang] . '</a>
        ';
      }
    ?>
    <a class="btn btn-small" href="<?php echo $path; ?>about.php">!</a>
  </div>
</nav>