<?php
  // return true if passed all validate else false
  function validate_sign_up($name, $password, $confirm_password, $email) {
    global $name_err, $password_err, $confirm_password_err, $email_err;
    $valid = true;

    if(!validate_xss($name)) {
      $name_err = '不合法的名稱(Invalid Name) !';
      $valid = false;
    }
    if(!validate_xss($password)) {
      $password_err = '不合法的密碼(Invalid Password) !';
      $valid = false;
    }
    if($password != $confirm_password) {
      $confirm_password_err = '密碼不一致(Different Password) !';
      $valid = false;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = '不合法的電子郵件(Invalid Email) !';
      $valid = false;
    }
    else {
      if(get_user($email)) {
        $email_err = '電子郵件已註冊過(Email already signed up) !';
        $valid = false;
      }
    }

    return $valid;
  }

  // return user if success else false
  function validate_login($email, $password) {
    global $email_err;

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = '不合法的電子郵件(Invalid Email) !';
      return false;
    }
    else {
      return validate_user($email, $password);
    }
  }

  function validate_user($email, $password) {
    global $password_err, $email_err;
    $user = get_user($email);
    if($user) {
      if(password_verify($password, $user['password'])) {
        // do not store hashed password in cookie
        // unset($user['password']);
        return $user;
      }
      else {
        $password_err = '密碼錯誤(Password Error) !';
        return false;
      }
    }
    else {
      $email_err = '尚未註冊的電子郵件(Did not Sign Up) !';
      return false;
    }
  }

  // return true if passed all validate else false
  function validate_modify_profile($avatar, $name, $new_password, $confirm_new_password) {
    global $avatar_err, $name_err, $new_password_err, $confirm_new_password_err;
    $valid = true;

    if($avatar['name']) {
      if($avatar['size'] > 5000000) {
        $avatar_err = '檔案需小於5MB(File must less than 5MB) !';
        $valid = false;
      }
      $allowed_avatar_format = array('image/png', 'image/jpeg', 'image/gif');
      if(!in_array($avatar['type'], $allowed_avatar_format)) {
        $avatar_err = '檔案格式須為jpg、jpeg、png、gif(File type must be jpg, jpeg, png, gif) !';
        $valid = false;
      }
    }
    if(!validate_xss($name)) {
      $name_err = '不合法的名稱(Invalid Name) !';
      $valid = false;
    }
    if($new_password) {
      if(!validate_xss($new_password)) {
        $new_password_err = '不合法的密碼(Invalid Password) !';
        $valid = false;
      }
      if($new_password != $confirm_new_password) {
        $confirm_new_password_err = '密碼不一致(Different Password) !';
        $valid = false;
      }
    }

    return $valid;
  }

  function validate_xss($string) {
    if(htmlspecialchars($string) != $string) return false;
    else return true;
  }

  //retuen true if pass recaptcha else alert
  function validate_recaptcha($recaptcha_response) {
    $recaptcha_err = '
      <script>
        if(!alert("你不是人類(You Are Not A Human) !"))
          window.history.back();
      </script>
    ';
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LcbRvUaAAAAAGz12DkIyIa5qckmWJhWV9ClTVpl';

    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    if($recaptcha->success == true && $recaptcha->score >= 0.5) {
      return true;
    }
    else {
      echo $recaptcha_err;
    }
  }
?>