<?php
  $allowed_lang = array('en', 'zh-TW');
  if(in_array($_COOKIE['lang'], $allowed_lang)) $lang = $_COOKIE['lang'];
  else $lang = 'en';
  $text = array(
    'login' => array(
      'en' => 'Login',
      'zh-TW' => '登入'
    ),
    'sign up' => array(
      'en' => 'Sign Up',
      'zh-TW' => '註冊'
    ),
    'dark' => array(
      'en' => 'Dark',
      'zh-TW' => '深色'
    ),
    'light' => array(
      'en' => 'Light',
      'zh-TW' => '淺色'
    ),
    'comment' => array(
      'en' => 'Comment',
      'zh-TW' => '留言'
    ),
    'show more' => array(
      'en' => 'Show More',
      'zh-TW' => '顯示更多'
    ),
    'show comments' => array(
      'en' => 'Show Comments',
      'zh-TW' => '顯示留言'
    ),
    'load more comments' => array(
      'en' => 'Load More Comments',
      'zh-TW' => '載入更多留言'
    ),
    'homepage' => array(
      'en' => 'Homepage',
      'zh-TW' => '首頁'
    ),
    'name' => array(
      'en' => 'Name',
      'zh-TW' => '名稱'
    ),
    'password' => array(
      'en' => 'Password',
      'zh-TW' => '密碼'
    ),
    'confirm' => array(
      'en' => 'Confirm',
      'zh-TW' => '確認'
    ),
    'email' => array(
      'en' => 'Email',
      'zh-TW' => '電子郵件'
    ),
    'must between' => array(
      'en' => 'Must between',
      'zh-TW' => '需介於'
    ),
    'characters' => array(
      'en' => 'characters',
      'zh-TW' => '個字'
    ),
    'must less than' => array(
      'en' => 'Must less than',
      'zh-TW' => '需少於'
    ),
    'logout' => array(
      'en' => 'Logout',
      'zh-TW' => '登出'
    ),
    'profile' => array(
      'en' => 'Profile',
      'zh-TW' => '個人資料'
    ),
    'last modified at' => array(
      'en' => 'Last Modified At',
      'zh-TW' => '最後修改時間'
    ),
    'create time' => array(
      'en' => 'Created At',
      'zh-TW' => '建立時間'
    ),
    'modify profile' => array(
      'en' => 'Modify Profile',
      'zh-TW' => '修改個人資料'
    ),
    'new' => array(
      'en' => 'New',
      'zh-TW' => '新'
    ),
    'avatar' => array(
      'en' => 'Avatar',
      'zh-TW' => '頭像'
    ),
    'post' => array(
      'en' => 'Post',
      'zh-TW' => '發布'
    ),
    'want to post something' => array(
      'en' => 'want to post something',
      'zh-TW' => '想說些甚麼'
    ),
    'user posts' => array(
      'en' => 'User Posts',
      'zh-TW' => '使用者文章'
    ),
    'about' => array(
      'en' => 'About',
      'zh-TW' => '關於'
    )
  );
?>