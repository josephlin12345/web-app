function show_more(post_id) {
  const form = document.getElementById(post_id);
  const content = form.getElementsByClassName('post-content')[0];
  const button = form.getElementsByTagName('button')[0];

  const show = content.classList.toggle('show-all-content');
  if(show) button.innerText = 'show less';
  else button.innerText = 'show more';
}

function decodeHTML(text) {
  return text.replace(/&amp;/g, '&').replace(/&quot;/g, '\"').replace(/&lt;/g, '<').replace(/&gt;/g, '>')
}

function make_post_element(post) {
  const clone = template.content.cloneNode(true);
  clone.querySelector('form').id = post['id'];
  clone.querySelector('img').src = `${api_url}/user/get_avatar.php?id=${post['creator_id']}`;
  clone.querySelector('a').href = `${window.location.origin}/app/user/posts.php?id=${post['creator_id']}`;
  clone.querySelector('.creator-name').innerText = post['creator_name'];
  const modified_at = new Date(post['modified_at']);
  modified_at.setMinutes(modified_at.getMinutes() - tzoffset);
  clone.querySelector('.modified-at').innerText = modified_at.toLocaleString();
  clone.querySelector('.post-content').innerText = decodeHTML(post['content']);
  clone.querySelector('button').setAttribute('onClick', `show_more(${post['id']})`);
  return clone;
}

function check_read_more_button(post_element) {
  const content = post_element.querySelector('.post-content');
  if(content.offsetHeight == content.scrollHeight) {
    const button = post_element.querySelector('button');
    post_element.removeChild(button);
  }
}

const api_url = 'http://i4010.isrcttu.net:9651/api';
let offset = 0;
const limit = 5;
let loading = false;
let stop_loading = false;
const tzoffset = (new Date()).getTimezoneOffset();
const posts_element = document.getElementById('posts');
const template = document.getElementById('post');