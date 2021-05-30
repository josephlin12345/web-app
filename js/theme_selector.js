const theme_selector = document.getElementById('theme-selector');

theme_selector.addEventListener('change', e => {
  const theme = e.target.value;
  document.body.className = theme;
  document.cookie = `theme=${theme}; max-age=2592000; path=/`;
});