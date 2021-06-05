<?php
  function validate_xss($string) {
    if(htmlspecialchars($string) != $string) return false;
    else return true;
  }

  function validate_recaptcha($recaptcha_response) {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LcbRvUaAAAAAGz12DkIyIa5qckmWJhWV9ClTVpl';

    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    if($recaptcha->success == true && $recaptcha->score >= 0.5) return true;
    else return false;
  }
?>