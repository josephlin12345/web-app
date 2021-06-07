<?php
  $allowed_lang = array('en', 'zh-TW');
  if(!in_array($lang, $allowed_lang)) $lang = 'en';
  $text = array(
    'missing data' => array(
      'en' => 'Missing data',
      'zh-TW' => '缺少資料'
    ),
    'did not pass recaptcha' => array(
      'en' => 'Did not pass recaptcha',
      'zh-TW' => '未通過驗證'
    ),
    'invalid name' => array(
      'en' => 'Invalid name',
      'zh-TW' => '不合法的名稱'
    ),
    'invalid password' => array(
      'en' => 'Invalid password',
      'zh-TW' => '不合法的密碼'
    ),
    'different password' => array(
      'en' => 'Different password',
      'zh-TW' => '密碼不一致'
    ),
    'invalid email' => array(
      'en' => 'Invalid email',
      'zh-TW' => '不合法的電子郵件'
    ),
    'email has been signed up' => array(
      'en' => 'Email has been signed up',
      'zh-TW' => '電子郵件已註冊過'
    ),
    'wrong password' => array(
      'en' => 'Wrong password',
      'zh-TW' => '密碼錯誤'
    ),
    'account has been deleted' => array(
      'en' => 'Account has been deleted',
      'zh-TW' => '帳號已被刪除'
    ),
    'did not sign up' => array(
      'en' => 'Did not sign up',
      'zh-TW' => '尚未註冊的電子郵件'
    )
  );
?>