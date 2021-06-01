function show_more(post_id) {
  const form = document.getElementById(post_id);
  const content = form.getElementsByClassName('post-content')[0];
  const button = form.getElementsByTagName('button')[0];

  const show = content.classList.toggle('show-all-content');
  if(show) button.innerText = 'show less';
  else button.innerText = 'show more';
}