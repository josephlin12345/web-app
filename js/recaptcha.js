function generate_token() {
  grecaptcha.execute('6LcbRvUaAAAAAEGnYLssRyYB5IHFj9mBKDHCcIPT', { action: 'submit' })
    .then(token => {
      document.getElementById('recaptcha_response').value = token;
    }
  );
}

grecaptcha.ready(() => {
  generate_token();
  setInterval(generate_token, 120000);
});