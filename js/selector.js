const theme_selector = document.getElementById('theme-selector');

theme_selector.addEventListener('change', e => {
  const theme = e.target.value;
  document.body.className = theme;
  document.cookie = `theme=${theme}; max-age=2592000; path=/`;
});

const lang_selector = document.getElementById('lang-selector');

lang_selector.addEventListener('change', e => {
  const lang = e.target.value;
  document.cookie = `lang=${lang}; max-age=2592000; path=/`;
  window.location = window.location.href;
});